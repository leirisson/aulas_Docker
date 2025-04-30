import 'dotenv/config'
import { Request, response, Response } from "express"
import { app } from "./app"

app.get('/', (req: Request, res: Response) => {
     res.send('Pagina inicial da api')
})


app.listen(process.env.PORT, () => {console.log(`server na porta http://localhost:${process.env.PORT}`)})