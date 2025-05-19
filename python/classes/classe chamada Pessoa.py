class Pessoa:
    def __init__(self, nome, idade):
        self.nome = nome
        self.idade = idade

    def imprimir_dados(self):
        print(f"Nome: {self.nome}")
        print(f"Idade: {self.idade}")

# Cria um objeto da classe Pessoa
pessoa1 = Pessoa("Maria", 30)

# Imprime os dados da pessoa
pessoa1.imprimir_dados()

# Você também pode acessar os atributos diretamente e imprimir:
print(f"\nNome (acesso direto): {pessoa1.nome}")
print(f"Idade (acesso direto): {pessoa1.idade}")