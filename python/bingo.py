import random

class SorteioPascoa:
    def __init__(self):
        self.todos_produtos = []
        self.produtos_disponiveis = []

    def inserir_produtos(self):
        print("🎁 Digite os nomes dos produtos de Páscoa que deseja sortear.")
        print("Digite 'fim' quando terminar.\n")
        while True:
            produto = input("Produto: ").strip()
            if produto.lower() == 'fim':
                break
            if produto:  # evita entradas vazias
                self.todos_produtos.append(produto)
        
        if not self.todos_produtos:
            print("\n❌ Nenhum produto inserido. Sorteio cancelado.")
            exit()

        self.produtos_disponiveis = self.todos_produtos.copy()
        print(f"\n✅ {len(self.todos_produtos)} produto(s) adicionado(s) com sucesso!\n")

    def sortear_produto(self):
        if not self.produtos_disponiveis:
            return None
        produto = random.choice(self.produtos_disponiveis)
        self.produtos_disponiveis.remove(produto)
        return produto

    def reiniciar_sorteio(self):
        self.produtos_disponiveis = self.todos_produtos.copy()
        print("\n🔁 Produtos reiniciados! Prontos para novo sorteio.\n")

    def iniciar(self):
        print("🐣 Bem-vindo ao Sorteio de Produtos de Páscoa! 🐣\n")
        self.inserir_produtos()

        while True:
            if not self.produtos_disponiveis:
                opcao = input("🎉 Todos os produtos foram sorteados! Deseja reiniciar? (sim/não): ").lower()
                if opcao == "sim":
                    self.reiniciar_sorteio()
                else:
                    print("👋 Sorteio encerrado. Feliz Páscoa!")
                    break
            else:
                input("Pressione Enter para sortear um produto...")
                sorteado = self.sortear_produto()
                print(f"🥚 Produto sorteado: {sorteado}\n")

# Executa o programa
if __name__ == "__main__":
    sorteio = SorteioPascoa()
    sorteio.iniciar()
