import axios from "axios";
import { Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import { PizzaStateController, PizzaRegistries } from "./tools.js";

window.axios = axios;

window.PizzaStateController = PizzaStateController;
window.PizzaRegistries = PizzaRegistries;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

Livewire.start();
