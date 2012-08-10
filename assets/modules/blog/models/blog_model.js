/**
 * backbone model definitions for CI3REST
 */

/**
 * Use emulated HTTP if the server doesn't support PUT/DELETE or application/json requests
 */
Backbone.emulateHTTP = false;
Backbone.emulateJSON = false

var model = {};


var siteUrl = "blog/blog_api/blog";
/**
 * long polling duration in miliseconds.  (5000 = recommended, 0 = disabled)
 * warning: setting this to a low number will increase server load
 */
model.longPollDuration = 0;

/**
 * whether to refresh the collection immediately after a model is updated
 */
model.reloadCollectionOnModelUpdate = true;

/**
 * Blog Backbone Model
 */
model.BlogModel = Backbone.Model.extend({
	urlRoot: siteUrl,
	idAttribute: 'idBlog',
	idBlog: '',
	titleBlog: '',
	bodyBlog: '',
	defaults: {
		'idBlog': null,
		'titleBlog': '',
		'bodyBlog': ''
	}
});

/**
 * Blog Backbone Collection
 */
model.BlogCollection = Backbone.Collection.extend({
	url: siteUrl,
	model: model.BlogModel,

	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	lastResponseText: null,
	collectionHasChanged: true,

	/**
	 * override parse to track changes and handle pagination
	 * if the server call has returned page data
	 */
	parse: function(response, xhr) {

		this.collectionHasChanged = (this.lastResponseText != xhr.responseText);
		this.lastResponseText = xhr.responseText;

		var rows;

		if (response.currentPage)
		{
			rows = response.rows;
			this.totalResults = response.totalResults;
			this.totalPages = response.totalPages;
			this.currentPage = response.currentPage;
			this.pageSize = response.pageSize;
		}
		else
		{
			rows = response;
			this.totalResults = rows.length;
			this.totalPages = 1;
			this.currentPage = 1;
			this.pageSize = this.totalResults;
		}

		return rows;
	}
});
