from db import  connection
from flask import jsonify,abort
class AvaliacaoDesempenhoService():


    def get_all_funcionarios(self, filtros):
        sql_filtros = " 1=1 "
        try:
            if "nome" in filtros:
                if filtros["nome"] != "":
                    sql_filtros+= f"""and f.nome like '%{filtros["nome"]}%' """

            if "id_departamento" in filtros:
                if filtros["id_departamento"] != "":
                    sql_filtros+= f"""and f.id_departamento = {filtros["id_departamento"]} """
           
            if "estado" in filtros:
                if filtros["estado"] != "":
                    sql_filtros+= f"""and f.estado = '{filtros["estado"]}' """

            query = f"""SELECT f.id, f.nome , f.genero as genero, f.data_nascimento, 
                        p.nome as provincia, d.nome as distrito, dp.nome as departamento,
                     f.contacto, f.estado FROM funcionario f
                    INNER JOIN provincia p on p.id = f.id_provincia
                    INNER JOIN distrito d on d.id = f.id_distrito 
                    INNER JOIN departamento dp on dp.id = f.id_departamento where {sql_filtros} order by f.nome"""
            
            cursor = connection.cursor()
            cursor.execute(query)
            funcionarios = cursor.fetchall()
            cursor.close()
        except Exception as ex:
            return jsonify({"message":ex})
        if funcionarios is None:
            abort(404)
        return jsonify({"data": funcionarios})
    

    def post_avaliacao(self,funcionario):
        try:
            query = """INSERT INTO avaliacao_desempenho
            (id_funcionario, id_indicador_desempenho, id_escala_pontuacao, data_inicio_avaliacao, data_fim_avaliacao, pontuacao)
             VALUES (%s, %s, %s, %s, %s, %s, %s);"""
            cursor = connection.cursor()
            cursor.execute(query,(funcionario["id_funcionario"],
                                  funcionario["id_indicador_desempenho"],
                                  funcionario["id_escala_pontuacao"],
                                  funcionario["contacto"],
                                  funcionario["id_provincia"],
                                  funcionario["pontuacao"]))
            connection.commit()
            cursor.close()
            # id_funcionario = cursor.lastrowid
        except Exception as ex:
            print(str(ex))
            return jsonify({"message": str(ex)})
        return jsonify({"data":{"success":True}, "message": "Funcionario avaliado com sucesso!"}), 201
    

    def getOneAvaliacao(self,id):

        try:
            query = """SELECT f.nome, f.genero, dp.nome as departamento, ep.descricao as situacao, idp.descricao as indicador
                       FROM avaliacao_desempenho ad INNER JOIN escala_pontuacao ep on ep.id =  ad.id_escala_pontuacao 
                       INNER JOIN indicador_desempenho idp on idp.id = ad.id_indicador_desempenho
                       INNER JOIN funcionario f on f.id = ad.id_funcionario
                       INNER JOIN departamento dp on dp.id = f.id_departamento and ad.id_funcionario = %s;"""
            
            cursor = connection.cursor()
            cursor.execute(query,(id))
            funcionario = cursor.fetchall()
            cursor.close()
        except Exception as ex:
            return jsonify({"message":str(ex),"code":500})
        if funcionario is None:
            abort(404)
        return jsonify({"data": funcionario})

#metodo actualizar
    def updateAvaliacao(self, id, funcionario):
        try:
            if("estado" in funcionario):
                if(funcionario["estado"] == ""):
                    query = """UPDATE funcionario
                            SET nome=%s, genero=%s, data_nascimento=%s, contacto=%s, 
                            id_provincia=%s, id_distrito=%s, id_departamento=%s
                            WHERE id=%s"""
                    
                    cursor = connection.cursor()
                    cursor.execute(query,(funcionario["nome"],
                                        funcionario["genero"],
                                        funcionario["data_nascimento"],
                                        funcionario["contacto"],
                                        funcionario["id_provincia"],
                                        funcionario["id_distrito"],
                                        funcionario["id_departamento"],id)) 
                if(funcionario["estado"] != ""):
                    print(funcionario["estado"])
                    query = """UPDATE funcionario
                            SET estado=%s
                            WHERE id=%s"""
                    cursor = connection.cursor()
                    cursor.execute(query,(funcionario["estado"],id))
            connection.commit()
           
        except Exception as ex:
            print(str(ex))
            return jsonify({"message": str(ex)})
        return jsonify({"data":{"success":True}, "message": "Funcionario actualizado com sucesso."}), 201
   
        

    def deleteAvaliacao(self, id):
        try:
            query = """UPDATE funcionario
            SET estado=%s
             WHERE id=%s"""
            cursor = connection.cursor()
            cursor.execute(query,("0",id))
            connection.commit()
           
        except Exception as ex:
            print(str(ex))
            return jsonify({"message": str(ex)})
        return jsonify({"data":{"success":True}, "message": "Funcionario desactivado com sucesso."}), 201
    
    
    def getTotal():
     try:
            query = """SELECT f.id, f.nome , f.genero as genero, f.data_nascimento, 
                        p.nome as provincia, d.nome as distrito, dp.nome as departamento,
                     f.contacto, estado FROM funcionario f
                    INNER JOIN provincia p on p.id = f.id_provincia
                    INNER JOIN distrito d on d.id = f.id_distrito 
                    INNER JOIN departamento dp on dp.id = f.id_departamento where {sql_filtros} order by f.nome"""
            cursor = connection.cursor()
            cursor.execute(query)
            funcionarios = cursor.fetchall()
            cursor.close()
     except Exception as ex:
            return jsonify({"message":ex})
     if funcionarios is None:
            abort(404)
     return jsonify({"data": funcionarios})
   
