class Carro:
    def __init__(self, marca, modelo, ano):
        self.marca = marca
        self.modelo = modelo
        self.ano = ano

    def descricao(self):
        print(f"Marca: {self.marca}")
        print(f"Modelo: {self.modelo}")
        print(f"Ano: {self.ano}")

# Cria um objeto da classe Carro
meu_carro = Carro("Volkswagen", "Gol", 2020)

# Chama o método descricao() para mostrar os dados do carro
print("Informações do carro:")
meu_carro.descricao()