import 'dotenv/config'
import { app } from "./app";
import {Request, Response} from 'express'

app.get('/', (request: Request, response:Response) => {

    response.send('Pagina inicial da api.')
})

app.listen(process.env.PORT,() => console.log(`server is runing in : ${process.env.PORT}`))