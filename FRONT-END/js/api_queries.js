// Obtém o elemento com o ID "registar_funcionario"
const btnRegistarFuncionario = document.getElementById("registar_funcionario");
const btnActualizarFuncionario = document.getElementById("actualizar_funcionario");
const btnDesactivarFuncionario = document.getElementById("desactivar_funcionario");

// Adiciona um ouvinte de evento de clique ao botão, chamando a função submitForm
btnRegistarFuncionario?.addEventListener("click", (e) =>
  submitForm(e, "form_funcionario", "funcionario/create.php")
);

btnActualizarFuncionario?.addEventListener("click", (e) => 
   submitForm(e, "form_funcionario_update", "funcionario/update.php")
);

btnDesactivarFuncionario?.addEventListener('click', (e) => 
{ alert('Deseja descativar?') }

);


/**
 * Função que valida um formulário com base no seu ID
 * @param {string} formularioID - ID do formulário a ser validado
 * @returns {number} - O número de erros de validação encontrados
 */
function validarFormulario(formularioID) {
  let errors_validation = 0;


  // Itera sobre cada elemento input, select e textarea dentro do formulário
  $(`#${formularioID}`)
    .find("input, select, textarea")
    .each(async function () {
      if (!$(this).prop("required")) {
        // Se o campo não for obrigatório, não faz nada
      } else {
        // Se o campo for obrigatório e o seu valor for vazio ou contiver apenas espaços em branco
        if ($(this).val() === null || $(this).val().length === 0 || !$(this).val().trim()) {
          // Adiciona classes de validação apropriadas e incrementa o contador de erros
          $(this)
            .removeClass("is-valid")
            .addClass("is-invalid")
            .addClass("has-error");
          errors_validation++;
        } else {
          // Remove as classes de validação
          $(this)
            .removeClass("is-invalid")
            .removeClass("has-error")
            .addClass("is-valid")
            .addClass("has-success");
        }
      }
    });

  // Retorna o número de erros de validação
  return errors_validation;
}

/**
 * Função que envia um formulário
 * @param {object} e - Evento de clique
 * @param {string} formularioID - ID do formulário a ser enviado
 * @param {string} endPoint - Ponto de extremidade para onde os dados devem ser enviados
 * @returns {Promise} - A resposta da operação
 */
async function submitForm(e, formularioID, endPoint) {
  // Mostra um indicador de carregamento
  showLoader();
  let errors_validation = 0;

  // Impede o envio padrão do formulário
  e.preventDefault();

  // Valida o formulário e obtém o número de erros de validação
  errors_validation = validarFormulario(formularioID);

 
  // Se não houver erros de validação, prossegue com o envio do formulário
  if (errors_validation == 0) {
    // Chama a função gravarDados para salvar os dados do formulário
    const data = await gravarDados(formularioID, endPoint);
    console.log(formularioID)

    // Manipula os dados de resposta e exibe mensagens de sucesso ou erro
    if (!data || data.error || data.code == 409 || data.status == 'Conflict') {
      // Exibe uma mensagem de erro usando a biblioteca SweetAlert
      Swal.fire({
        icon: "error",
        title: `${data}`,
        text: `${data}`,
        showConfirmButton: true,
      });
    } else {

      // Exibe uma mensagem de sucesso com base no ID do formulário
      if (formularioID == "form_funcionario") {
        Swal.fire({
          icon: "success",
          title: `${data.message}`,
          showConfirmButton: false,
          timer: 1500,
        }).then((result) => {
          if (result.dismiss) {
           
            location.assign('listagem_funcionarios.php');
          }
        });
      } else if (formularioID == "form_funcionario_update") {
        console.log(data)
          Swal.fire({
            icon: "success",
            title: `${data.message}`,
            showConfirmButton: false,
            timer: 1500,
          }).then((result) => {
            if (result.dismiss) {
             location.assign('listagem_funcionarios.php');             
            }
        });
      } 
       //Acrescentar outras exibições de mensagens
      
    }
    
  } else {
    // Exibe uma mensagem de erro caso haja campos obrigatórios não preenchidos
    Swal.fire({
      icon: "error",
      title: "Por favor preencha os campos obrigatórios!",
      showConfirmButton: true,
    });
  }

  // Esconde o indicador de carregamento
  hideLoader();
}

/**
 * Função que envia os dados do formulário para o servidor
 * @param {string} formularioID - ID do formulário
 * @param {string} endPoint - Ponto de extremidade para onde os dados devem ser enviados
 * @returns {Promise} - A resposta do servidor
 */
async function gravarDados(formularioID, endPoint) {
  // Obtém o formulário com base no seu ID
  const formulario = document.querySelector(`#${formularioID}`);

  // Cria um objeto FormData com os dados do formulário
  const formularioPreparado = new FormData(formulario);

  // Faz uma solicitação POST assíncrona para o servidor usando fetch
  let response = await fetch(`./app/ajax/${endPoint}`, {
    method: "POST",
    body: formularioPreparado,
  })
    .then((data) => {
      return data.json();
    })
    .catch((err) => {
      console.log(err);
      return {
        message: "Ocorreu um erro na execução da operação",
        error: true,
      };
    });

  // Retorna a resposta do servidor
  return response;
}
