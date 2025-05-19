class Retangulo:
    def __init__(self, largura, altura):
        self.largura = largura
        self.altura = altura

    def calcular_area(self):
        return self.largura * self.altura

# Cria um retângulo de 10x6
meu_retangulo = Retangulo(10, 6)

# Calcula e mostra a área
area = meu_retangulo.calcular_area()
print(f"A área do retângulo é: {area}")