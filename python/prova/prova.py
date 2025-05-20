# Escreva um código que use a função print() para mostrar a frase "Bem-vindo à aula de Python".
print("Bem-vindo à aula de Python")

# Escreva um código que use a função input() para perguntar o nome do usuário e, em seguida, mostre uma mensagem de boas-vindas com o nome.
print("Qual é o seu nome?")
nome = input("digite seu nome: ")
print("Bem-vindo, " + nome + "!")

# Escreva um código que crie uma lista com 3 frutas e imprima a segunda fruta da lista.
frutas = ["maçã", "banana", "laranja"]
print(frutas[1])

# Escreva um código com um laço for que percorra uma lista com 3 números e imprima cada um deles.
numeros = [1, 2, 3]
for numero in numeros:
    print(numero)

# Escreva um código que crie uma classe chamada Pessoa com os atributos nome e idade, e depois crie um objeto dessa classe.
class Pessoa:
    def __init__(self, nome, idade):
        self.nome = nome
        self.idade = idade
pessoa1 = Pessoa("Erick", 30)
print(pessoa1.nome)

# Escreva um código que use uma estrutura if e else para verificar se a idade digitada pelo usuário é maior ou igual a 18. Se for, mostre "Maior de idade", senão mostre "Menor de idade".
idade = int(input("Digite sua idade: "))  
if idade >= 18:
    print("Maior de idade") 
else:
    print("Menor de idade")