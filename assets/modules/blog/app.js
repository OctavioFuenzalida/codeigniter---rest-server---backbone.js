/**
 * Application logic available globally throughout the app
 */
var app = {

	/** @var landmarks used to screen-scrape the html error output for a friendly message */
	errorLandmarkStart: '<!-- ERROR ',
	errorLandmarkEnd: ' /ERROR -->',

	/**
	 * Display an alert message inside the element with the id containerId
	 *
	 * @param string message to display
	 * @param string style: '', 'alert-error', 'alert-success' or 'alert-info'
	 * @param int timeout for message to hide itself
	 * @param string containerId (default = 'alert')
	 */
	appendAlert: function(message,style, timeout,containerId) {

		if (!style) style = '';
		if (!timeout) timeout = 0;
		if (!containerId) containerId = 'alert';

		var id = _.uniqueId('alert_');

		var html = '<div id="'+id+'" class="alert '+ this.escapeHtml(style) +'" style="display: none;">'
			+ '<a class="close" data-dismiss="alert">&times;</a>'
			+ '<span>'+ this.escapeHtml(message) +'</span>'
			+ '</div>';

		$('#' + containerId).append(html);
		$('#'+containerId).scrollIntoView();
		$('#'+id).slideDown('fast');

		if (timeout > 0) {
			setTimeout("app.removeAlert('"+id+"')",timeout);
		}
	},

	/**
	 * Remove an alert that has been previously shown
	 * @param string element id
	 */
	removeAlert: function(id) {

		$("#"+id).slideUp('fast', function(){
			$("#"+id).remove();
		});
	},

	/**
	 * show the progress bar
	 * @param the id of the element containing the progress bar
	 */
	showProgress: function(elementId)
	{
		$('#'+elementId).show();
		// $('#'+elementId).animate({width:'150'},'fast');
	},

	/**
	 * hide the progress bar
	 * @param the id of the element containing the progress bar
	 */
	hideProgress: function(elementId)
	{
		setTimeout("$('#"+elementId+"').hide();",100);
		// $('#'+elementId).animate({width:'0'},'fast');
	},

	/**
	 * Escape unsafe HTML chars to prevent xss injection
	 * @param string potentially unsafe value
	 * @returns string safe value
	 */
	escapeHtml: function(unsafe) {
		return _.escape(unsafe);
	},

	/**
	 * Accept string in the following format: 'YYYY-MM-DD hh:mm:ss' or 'YYYY-MM-DD'
	 * If a date object is padded in, it will be returned as-is
	 * @param string | date:
	 * @returns Date
	 */
	parseDate: function(str) {

		if (str instanceof Date) return str;

		var d;
		try
		{
			var dateTime = str.split(' ');
			var dateParts = dateTime[0].split('-');
			var timeParts = dateTime.length > 1 ? dateTime[1].split(':') : array('00','00','00');
			d = new Date(dateParts[0], dateParts[1]-1, dateParts[2], timeParts[0], timeParts[1], timeParts[2]);
		}
		catch (error)
		{
			if (console) console.log('app.parseDate: ' + error.message);
			d = new Date();
		}

		return d ? d : new Date();
	},

	/**
	 * Convenience method for creating an option
	 */
	getOptionHtml: function(val,label,selected)
	{
		return '<option value="' + _.escape(val) + '" ' + (selected ? 'selected="selected"' : '') +'>'
			+ _.escape(label)
			+ '</option>'
	},

	/**
	 * A server error should contain json data, but if a fatal php error occurs it
	 * may contain html.  the function will parse the return contents of an
	 * error response and return the error message
	 * @param server response
	 */
	getErrorMessage: function(resp) {

		var msg = 'Error en el servidor desconocido';
		try
		{
			var json = $.parseJSON(resp.responseText);
			msg = json.message;
		}
		catch (error)
		{
			// TODO: possibly use regex or some other more robust way to get details...?
			var parts = resp.responseText.split(app.errorLandmarkStart);

			if (parts.length > 1)
			{
				var parts2 = parts[1].split(app.errorLandmarkEnd);
				msg = parts2[0]
			}
		}

		return msg ? msg : 'Error en el servidor desconocido';
	},

	version: 1.0

}