class Livro:
    def __init__(self, titulo, autor, paginas):
        self.titulo = titulo
        self.autor = autor
        self.paginas = paginas

# Cria 3 livros diferentes
livro1 = Livro("Dom Quixote", "Miguel de Cervantes", 863)
livro2 = Livro("Cem Anos de Solidão", "Gabriel García Márquez", 417)
livro3 = Livro("1984", "George Orwell", 328)

# Mostra o título do segundo livro
print(f"O título do segundo livro é: {livro2.titulo}")