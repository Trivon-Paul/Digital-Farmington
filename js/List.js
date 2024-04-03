( function(window) {
		var List = ( function() {
				function List() {
					this.items = [];
				}


				List.prototype = {
					add : function(item) {
						this.items.push(item);
						
					},
					remove : function(item) {
						var indexOf = this.items.indexOf(item);
						if(indexOf !== -1) {
							this.items.splice(indexOf, 1);
						}
					},
					removeAll:function(){
						this.items =[];
					},
					find : function(callback, action) {
						var callbackResult, i = 0, matches = [];
						for(; i < this.items.length; i++) {
							callbackResult = callback(this.items[i]);
							if(callbackResult) {
								matches.push(this.items[i]);
							}

						}
						if(action) {

							action.call(this, matches);
						}

						return matches;
					}
				}
				return List;
			}());
		window.List = List;
	}(window))
