import axios from "axios";
import { Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import { PizzaConfig } from "./pizza/tools.js";
import createPizzaState from "./pizza/pizzaState.js";

window.axios = axios;

window.createPizzaState = createPizzaState;
window.PizzaConfig = PizzaConfig;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

Livewire.start();
