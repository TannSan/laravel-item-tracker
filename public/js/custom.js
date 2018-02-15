/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/custom.js":
/***/ (function(module, exports) {


var item_log = $('textarea#item-log');
function leadingZeros(message_time) {
    return message_time < 10 ? '0' + message_time : message_time;
}

function itemLog(message) {
    var dt = new Date();
    var message_time = leadingZeros(dt.getHours()) + ":" + leadingZeros(dt.getMinutes());
    item_log.val(item_log.val() + '\n' + message_time + ' ' + message);
    item_log.scrollTop(item_log[0].scrollHeight);
}

$("ol.user-container").sortable({
    group: 'system-users',
    handle: 'span.glyphicon-move',
    onDrop: function onDrop($item, container, _super) {

        /**
         *  If this is the new-template list item then clone it back to the original position and then configure this copy
         */
        if ($item.attr('id') == 'new-item') {
            $item.removeAttr('id');
            $('input', $item).prop("disabled", false);
            $item.append('<ol></ol>');

            var new_item = $('li#new-template').clone();
            new_item.attr('id', 'new-item');
            new_item.prependTo("ol.new-container");
            new_item.show();
        }

        $.ajax({
            method: 'POST',
            url: '/list',
            data: {
                'testsend': 'somedata'
            },
            headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
        }).done(function (json_response) {
            $("div.alert-success").html(json_response.test);
            console.log(json_response);
            itemLog(json_response);
        });
        _super($item, container);
        return false;
    }
});

$("ol.new-container").sortable({
    group: 'system-users',
    drop: false,
    handle: 'span.glyphicon-move',
    onDrop: function onDrop($item, container, _super) {
        console.log("Dropped");
        _super($item, container);
        return false;
    }
});

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/custom.js");


/***/ })

/******/ });