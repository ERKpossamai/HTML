class Aluno:
    def __init__(self, nome, nota):
        self.nome = nome
        self.nota = nota

    def mostrar_nota(self):
        print(f"Nota do aluno: {self.nota}")

# Cria o primeiro aluno
aluno1 = Aluno("João", 8.5)

# Cria o segundo aluno
aluno2 = Aluno("Maria", 9.2)

# Chama o método mostrar_nota() para cada aluno
print(f"Informações do aluno {aluno1.nome}:")
aluno1.mostrar_nota()

print(f"\nInformações da aluna {aluno2.nome}:")
aluno2.mostrar_nota()