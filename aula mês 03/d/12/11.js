let frutas = ["maçã", "banana", "laranja"]
let numeros = new Array(10, 20, 30)
let vazio = new Array(3)// Array com 3 posições vazias
console.log(frutas[0])
console.log(frutas[1])
console.log(frutas[2])

frutas[1] = "uva" // Ira substituir "banana" por "uva"
console.log(frutas)
frutas.push("abacaxi") // vai inserir um valor 
console.log(frutas)
frutas.pop()// Ira remover o ultimo item da lista 
console.log(frutas)
frutas.unshift("morango") // Inserem um item no começo da lista
console.log(frutas)
frutas.shift()// Remove um item do inicio da lista 
console.log(frutas)
frutas.splice (1 , 1)// Remove 1 elemento a partir do inicio
console.log(frutas)

let citrus = frutas.slice(1, 3)
console.log(citrus)
console.log(frutas.indexOf("laranja"))
console.log(frutas.indexOf("kiwi"))
