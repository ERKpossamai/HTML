import time

print("Contagem regressiva:")
for i in range(5, 0, -1):
    print(i)
    time.sleep(1)  # Espera 1 segundo entre cada número
print("Fogo!")