from db import  connection
from flask import jsonify,abort
from datetime import date

class PresencaService():
# colocar a presenca de um funcionario
   def post_presencas(self, presenca):
       try:
            today = date.today()


            query = f"""SELECT p.id_funcionario as id_funcionario
                        from presenca p INNER JOIN funcionario f 
                        ON p.id_funcionario=f.id WHERE p.data_marcacao = '{today}' AND
                        p.id_funcionario={presenca["id_funcionario"]};"""
            
            cursor = connection.cursor()
            cursor.execute(query)
            funcionario = cursor.fetchone()                   
            connection.commit()

            if funcionario is None:

                query = """INSERT INTO presenca (hora_entrada, id_funcionario)
                    VALUES (CURRENT_TIMESTAMP, %s);"""
                # cursor = connection.cursor()
                cursor.execute(query,(presenca["id_funcionario"] ))
                connection.commit()
                cursor.close()
                id_presenca = cursor.lastrowid
                

                return jsonify({"data":{"id":id_presenca}, "message": "Presenca marcada com sucesso!","success":True })
            else:
                return jsonify({"data":{},"message": "Esta presenca ja foi marcada anteriormente!","success":False })
       except Exception as ex:
           print(str(ex))
           return jsonify({"message": str(ex)})
       

               
   def update_saida(self, presenca):
        try:
                today = date.today()

            #    if PresencaService.get_presenca(presenca["id_funcionario"], presenca["tipo_presenca"]):

                query = f"""SELECT p.id_funcionario as id_funcionario, p.hora_entrada, p.hora_saida
                        from presenca p INNER JOIN funcionario f ON p.id_funcionario = f.id
                        WHERE p.data_marcacao = '{today}' AND p.id_funcionario={presenca["id_funcionario"]};"""
                cursor = connection.cursor()
                cursor.execute(query)
                funcionario = cursor.fetchone()                   
                connection.commit()

                if funcionario["hora_saida"] is None:

                    query = """UPDATE presenca set presente = 1, hora_saida = CURRENT_TIMESTAMP where data_marcacao=CURDATE() AND id_funcionario = %s;"""
                    # cursor = connection.cursor()
                    cursor.execute(query,(presenca["id_funcionario"]))
                    connection.commit()
                    cursor.close()
                    id_presenca = cursor.lastrowid

                    return jsonify({"data":{"id":id_presenca}, "message": "Saida marcada com sucesso!","success":True })
                else:
                    return jsonify({"data":{},"message": "Esta Saida ja foi marcada anteriormente!","success":False })
        except Exception as ex:
            print(str(ex))
            return jsonify({"message": str(ex)})
   

   def get_one_presencas(self,id_funcionario):
        try:
            query = f"""SELECT pr.id, pr.id_funcionario, f.nome, pr.presente, data_marcacao, date_format(pr.hora_entrada, "%H:%i:%s") hora_entrada,
                        date_format(pr.hora_saida, "%H:%i:%s") hora_saida FROM presenca pr
                        INNER JOIN funcionario f ON pr.id_funcionario = f.id where f.id = {id_funcionario} """
            cursor = connection.cursor()
            cursor.execute(query)
            presencas = cursor.fetchall()
            connection.commit()
            cursor.close()
        except Exception as ex:
            return jsonify({"message":str(ex)})
        if presencas is None:
            abort(404)
        return jsonify({"data": presencas})


   def get_all_funcionarios_presenca(self, filtros):
        sql_filtros = " 1=1 "

        try:
            if "nome" in filtros:
                if filtros["nome"] != "":
                    sql_filtros+= f"""and f.nome like '%{filtros["nome"]}%' """

            # if "hora_entrada" in filtros:
            #     if filtros["hora_entrada"] != "":
            #         sql_filtros+= f"""and date_format(pr.hora_entrada,"%H:%i:%s")hora_entrada like '%{filtros["hora_entrada "]}%' """

            # if "id_provincia" in filtros:
            #     if filtros["id_provincia"] != "":
            #         sql_filtros+= f"""and f.id_provincia = {filtros["id_provincia"]} """

            # if "id_distrito" in filtros:
            #     if filtros["id_distrito"] != "":
            #         sql_filtros+= f"""and f.id_distrito = {filtros["id_distrito"]} """

            # if "genero" in filtros:
            #     if filtros["genero"] != "":
            #         sql_filtros+= f"""and f.genero = '{filtros["genero"]}' """

            # if "data_nascimento1" in filtros:
            #     if (filtros["data_nascimento1"] != "") and (filtros["data_nascimento2"] != ""):
            #         sql_filtros+= f"""and (f.data_nascimento BETWEEN '{filtros["data_nascimento1"]}' AND '{filtros["data_nascimento2"]}') """

           
            query = f"""SELECT f.id, f.nome , f.genero as genero, f.data_nascimento, p.nome as provincia, d.nome as distrito, 
                        dp.nome as departamento, f.contacto, (SELECT date_format(pr.hora_entrada,"%H:%i:%s") hora_entrada 
                        FROM presenca pr WHERE pr.id_funcionario=f.id AND pr.data_marcacao=CURDATE()) as hora_entrada, 
                        (SELECT date_format(pr.hora_saida,"%H:%i:%s") hora_saida FROM presenca pr 
                        WHERE pr.id_funcionario=f.id AND pr.data_marcacao=CURDATE()) as hora_saida,
                        (SELECT presente FROM presenca pr 
                        WHERE pr.id_funcionario=f.id AND pr.data_marcacao=CURDATE()) as presenca
                        FROM funcionario f
                        INNER JOIN provincia p on p.id = f.id_provincia
                        INNER JOIN distrito d on d.id = f.id_distrito
                        INNER JOIN departamento dp on dp.id = f.id_departamento
                        WHERE estado = 1 AND {sql_filtros} order by f.nome"""
                     
            # print(query)
            cursor = connection.cursor()
            cursor.execute(query)
            funcionarios = cursor.fetchall()
            array_funcionarios = []
            for funcionario in funcionarios:
             array_funcionarios.append(funcionario)
            cursor.close()
        except Exception as ex:
            return jsonify({"message": str(ex)})
        if funcionarios is None:
            abort(404)
        return jsonify(array_funcionarios)
   

   def get_all_terminar_controle(self):
            
            try:
                
                query = f"""SELECT funcionario.* FROM funcionario
                            LEFT JOIN presenca ON funcionario.id = presenca.id_funcionario
                            AND presenca.data_marcacao = CURRENT_DATE
                            WHERE presenca.id_funcionario IS NULL 
                            AND funcionario.estado = 1;"""
                        
                cursor = connection.cursor()
                cursor.execute(query)
                connection.commit()
                funcionarios = cursor.fetchall()
                
                for funcionario in funcionarios:
                   query = """INSERT INTO presenca (id_funcionario)
                              VALUES (%s);"""
                   cursor = connection.cursor()
                   cursor.execute(query,(funcionario['id']))
                   connection.commit()
                   cursor.close()
       
            except Exception as ex:
                return jsonify({"message": str(ex)})
            if funcionarios is None:
                abort(404)
            return jsonify({"message": "Controle encerrado com sucesso!","success":True })
