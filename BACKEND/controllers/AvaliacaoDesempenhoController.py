from flask_smorest import Blueprint
from flask.views import MethodView
from flask import request
from services import AvaliacaoDesempenhoService
blp = Blueprint("avaliacao_desempenho",__name__, description="Operacoes sobre a avaliacao de desempenho")


@blp.route("/avaliacao-desempenho")
class AvaliacaoDesempenhoController(MethodView):
    def post(self):
        return AvaliacaoDesempenhoService.post_avaliacao(self, presenca=request.get_json())
    
    def put(self):
        return AvaliacaoDesempenhoService.updateAvaliacao(self,presenca=request.get_json())
    
    def get(self):
        return AvaliacaoDesempenhoService.get_all_funcionarios(self,filtros=request.get_json()) 
    

@blp.route("/avaliacao-desempenho/<int:id_avaliacao>")
class AvaliacaoDesempenhoController(MethodView):
    def get(self, id_avaliacao):
        return AvaliacaoDesempenhoService.getOneAvaliacao(self, id_avaliacao)
    


    

# @blp.route("/presencas")
# class PresencaFuncionarioController(MethodView):
#     def post(self):
#         return PresencaFuncionarioService.post_createSaida(self, presenca=request.get_json())