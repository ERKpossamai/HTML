console.log(`\nTrabalho com condicionais`);
const listaDeDestinos = new Array (
    `Salvador`,
    `São Paulo`,
    `Rio de Janeiro`,
);

const idadeComprador = 18;
const estaAcompanhada = false;
let temPassagemComprada = false;
const destino = "Cascavel";

console.log("\n Destinos possíveis");
console.log(listaDeDestinos);

const podeComprar = idadeComprador >= 18 || estaAcompanhada == true;
// Se for maior ou igual a 18 (||) ou esta acompanhado será verdadeiro
let contador = 0; //iniciando o contador com zero 
let destinoExiste = false;
while(contador<3){/*enquanto o contador dor menor que 3 ele vai criar um lupe*/
    if(listaDeDestinos[contador] == destino) {
        destinoExiste = true;
        break;//parando o programa
    }
    contador += 1;
}

console.log("Destino exite : ", destinoExiste);

if(podeComprar && destinoExiste){
    console.log("Boa Viagem");
}else{
    console.log("Desculpe tivemos um erro!!");
}
for( let i = 0 ; i <3 ; i++){
      if(listaDeDestinos[i] == destino){
        destinoExiste = true;
      }
}