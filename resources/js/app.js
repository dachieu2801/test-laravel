import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import $ from 'jquery';
import 'select2';

// Khởi tạo Select2 cho các trường select có class .select2
$(document).ready(function() {
    $('.select2').select2();
});