import axios from "axios";
import { Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import { PizzaConfig } from "./tools/pizza/tools.js";
import PizzaStateController from "./tools/pizza/pizzaStateController.js";

window.axios = axios;

window.PizzaStateController = PizzaStateController;
window.PizzaConfig = PizzaConfig;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

Livewire.start();
