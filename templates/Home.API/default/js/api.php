/**
 * @file
 * Make calls to the API.
 *
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */
 
 
function HomeAPI() {}

HomeAPI.extractBody = function(data, handler) {
    handler(data['body']);
}

HomeAPI.call = function(api, data, handler, method) {
   var baseurl = Environment.wwwroot + 'api/'; 

   if (method == 'POST')
   {
        $.ajax({
            type: "POST",
            url: baseurl + api, 
            data: data, 
            success: handler,
            dataType: "json"
        });
   }
   else
   {
        $.getJSON(baseurl + api, data, handler);
   }
}
