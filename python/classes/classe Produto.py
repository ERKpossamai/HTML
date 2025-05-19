class Produto:
    def __init__(self, nome, preco):
        self.nome = nome
        self.preco = preco

# Cria um objeto da classe Produto
meu_produto = Produto("Lápis", 1.50)

# Mostra as informações usando print
print(f"Nome do produto: {meu_produto.nome}")
print(f"Preço do produto: R$ {meu_produto.preco:.2f}")