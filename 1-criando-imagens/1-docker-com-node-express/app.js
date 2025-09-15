const express = require('express')
const app = express()
const port = 3333

app.get('/', (request, response) => {
    response.send('Olá Deu certo.')
})


app.listen(port, () => {
    console.log(`Executando na url: http://localhost:${port}`)
})