/**
 * User Log
 * Author: David Millington
 */

var item_log = $('textarea#item-log');
item_log.val('');

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
    if(interactive)
        {
            var dt = new Date();
            var message_time = leadingZeros(dt.getHours()) + ":" + leadingZeros(dt.getMinutes());
            item_log.val(item_log.val() + message_time + ' ' + message + '\n');
            item_log.scrollTop(item_log[0].scrollHeight);
        }
}

// Initialise the action log.
itemLog('Welcome!');