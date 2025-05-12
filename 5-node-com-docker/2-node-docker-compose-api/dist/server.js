"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
require("dotenv/config");
const app_1 = require("./app");
app_1.app.get('/', (request, response) => {
    response.send('Pagina inicial da api.');
});
app_1.app.listen(process.env.PORT, () => console.log(`server is runing in : ${process.env.PORT}`));
