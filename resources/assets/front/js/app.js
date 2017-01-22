/**
 * Created by vladislav on 14.1.17.
 */
window.$ = global.jQuery = require('jquery');

require('bootstrap');  //@4.0.0-alpha.2

global.app = {

    //Modules
    main: require('./app/main'),
    maps: require('./app/maps'),

    init: function(options) {
        app.main.init();
    }

};
