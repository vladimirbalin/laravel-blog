import axios from "axios";
import $ from 'jquery';

let config = {
    csrfCookieName: null,
    xsrfCookieName: null,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'X-Requested-With': 'XMLHttpRequest'
    }
}

const httpService = axios.create(config);

export default httpService;
