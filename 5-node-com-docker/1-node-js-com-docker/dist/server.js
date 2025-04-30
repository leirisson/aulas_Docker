"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
require("dotenv/config");
const app_1 = require("./app");
app_1.app.get('/', (req, res) => {
    res.send('Pagina inicial da api');
});
app_1.app.listen(process.env.PORT, () => { console.log(`server na porta http://localhost:${process.env.PORT}`); });
