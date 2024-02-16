from flask_smorest import Blueprint
from flask.views import MethodView
from flask import request
from services import FuncionarioService
blp = Blueprint("funcionarios",__name__, description="Operacoes sobre o funcionario")

@blp.route("/funcionario")
class FuncionarioController(MethodView):
    def get(self):
        return FuncionarioService.get_all_funcionarios(self,filtros= request.get_json())

    def post(self):
        return FuncionarioService.post_funcionario(self,funcionario=request.get_json())


@blp.route("/funcionario/<int:id>")
class FuncionariosController(MethodView):
    def get(self,id):
        return FuncionarioService.getOneFuncionario(self,id)
    def put(self,id):
        return FuncionarioService.updateFuncionario(self,id,funcionario=request.get_json())
    def delete(self,id):
        return FuncionarioService.deleteFuncionario(self,id)


