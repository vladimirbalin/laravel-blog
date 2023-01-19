import axios from "axios";
import $ from 'jquery';

let config = {}

const httpService = axios.create(config);

export default httpService;
