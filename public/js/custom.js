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

/**
 * Item List Mechanics
 * Author: David Millington
 */

// Reset the new item text to avoid caching issue
$('li#new-item input').val('New Item');

// Setup our action log
var item_log = $('textarea#item-log');

/**
 * Adds leading zeros to time values if needed.
 * @param {int} message_time 
 */
function leadingZeros(message_time) {
    return message_time < 10 ? '0' + message_time : message_time;
}

/**
 * Writes to the action log.
 * @param {string} message 
 */
function itemLog(message) {
    var dt = new Date();
    var message_time = leadingZeros(dt.getHours()) + ":" + leadingZeros(dt.getMinutes());
    item_log.val(item_log.val() + '\n' + message_time + ' ' + message);
    item_log.scrollTop(item_log[0].scrollHeight);
}

// This is the template that is used when we create list items via AJAX calls.  It uses ## values which are string replaced later on
var list_item_template = '<li data-id="#id#" data-title="#title#"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="#title#" placeholder="Enter Item Name" /></div></li>';

/**
 * Populates a sorted list with items.
 * @param {JQuery object for a list} target_list 
 * @param {JSON} list_data 
 */
function populateList(target_list, list_data) {
    var children;
    var new_list_item;
    var new_list_item_child_list;
    $.each(list_data[0], function (index) {
        // Create and attach new list item
        new_list_item = $(list_item_template.replace(/#id#/, list_data[0][index].id).replace(/#title#/g, 'Item' + list_data[0][index].id));
        target_list.append(new_list_item);

        // Create and attach new list item child list
        new_list_item_child_list = $('<ol></ol>');
        new_list_item.append(new_list_item_child_list);

        // Recurse into children (if any)
        children = list_data[0][index].children;
        if (children[0].length > 0) populateList(new_list_item_child_list, children);
    });
}
populateList($('ol.user-container[data-user-id="2"]'), [[{ "id": 1, "children": [[]] }, { "id": 2, "children": [[]] }, { "id": 3, "children": [[]] }, { "id": 4, "children": [[{ "id": 25, "children": [[{ "id": 35, "children": [[]] }, { "id": 55, "children": [[]] }]] }]] }, { "id": 5, "children": [[]] }, { "id": 6, "children": [[]] }, { "id": 7, "children": [[]] }, { "id": 8, "children": [[]] }]]);

// Setup the sortable list components
$("ol.user-container").sortable({
    group: 'system-users',
    handle: 'span.glyphicon-move',
    onDrop: function onDrop($item, container, _super) {

        // If this is the new-template list item then clone it back to the original position and then configure this copy
        if ($item.attr('id') == 'new-item') {
            $item.removeAttr('id');
            $('input', $item).prop("disabled", false);
            $('input', $item).val('');
            $('input', $item).focus();
            $item.append('<ol></ol>');

            // Clone the hidden template and display it so they can create another new list item
            var new_item = $('li#new-template').clone();
            new_item.attr('id', 'new-item');
            new_item.prependTo("ol.new-container");
            new_item.show();
        }

        /**
         * Post the updated item position to the controller
         */
        /*
        console.log("Container:");
        console.log(container);
        console.log("Item:");
        console.log($item);
        */

        // If the item is a direct descendant of a user container...
        if (container.el.hasClass('user-container')) {
            console.log("Direct Descendant");
        } else {
            console.log("Child Of: " + container.el.parent().data('id'));
        }

        // console.log(JSON.stringify(container.serialize()));

        $.ajax({
            method: 'POST',
            url: '/list',
            data: {
                'item-id': $item.attr('id')
            },
            headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
        }).done(function (json_response) {
            // $("div.alert-success").html(json_response.test);
            console.log("AJAX Response:");
            console.log(json_response);
            // itemLog(json_response);
        });
        _super($item, container);
        return false;
    }
});

// Track the panel that the dragged item was originally from so we can force a refresh on it after saving the changes
var source_panel_list;
$("ol.user-container").mousedown(function (event) {
    console.log('Source Panel User ID: ' + $(this).data('user-id'));
    //event.preventDefault();
    //return true;
});

// Setup the New Item panel
$("ol.new-container").sortable({
    group: 'system-users',
    drop: false,
    handle: 'span.glyphicon-move'
});

/**
 * Save the list item to the database.
 * @param {JQuery object for the list item Text Input} target 
 */
function saveListItem(target) {
    if (target.val() != target.closest('li').data('title')) console.log("Saving: " + target.val());
}

/**
 * Save the changes when enter is pressed within one of the text inputs or when it loses focus.
 */
function listItemEnterKey(event) {
    if (event.which == 13) {
        saveListItem($(this));
        $(this).blur();
    }
}
function listItemLoseFocus() {
    saveListItem($(this));
}

// Attach the enter keypress and focus events to the document so they also apply to items dynamically created later on, also avoids associating tons of event listeners.
$(document).on('keypress', 'ol.user-container input.form-control', listItemEnterKey);
$(document).on('focusout', 'ol.user-container input.form-control', listItemLoseFocus);

// Test re-activing a list when it is changed after the original init
// populateList($('ol.user-container[data-user-id="3"]'),  [[{"id":1,"children":[[]]},{"id":2,"children":[[]]},{"id":3,"children":[[]]},{"id":4,"children":[[{"id":25,"children":[[{"id":35,"children":[[]]}, {"id":55,"children":[[]]}]]}]]},{"id":5,"children":[[]]},{"id":6,"children":[[]]},{"id":7,"children":[[]]},{"id":8,"children":[[]]}]]);


// Fetch Test Data
//console.log(JSON.stringify($('ol.user-container[data-user-id="2"]').sortable("serialize").get()));
//console.log(JSON.stringify($('ol.user-container[data-user-id="3"]').sortable("serialize").get()));

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/custom.js");


/***/ })

/******/ });