/**
 * jQuery Multifield plugin
 * fix v.0.4 for OptMoscow 25/07/2019 - fix delete button
 * fix v.0.3 for OptMoscow 14/09/2018 - update ids
 *
 * https://github.com/maxkostinevich/jquery-multifield
 */


// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, document, undefined ) {

	/*
	 * Plugin Options
	 * section (string) -  selector of the section which is located inside of the parent wrapper
	 * max (int) - Maximum sections
	 * btnAdd (string) - selector of the "Add section" button - can be located everywhere on the page
	 * btnRemove (string) - selector of the "Remove section" button - should be located INSIDE of the "section"
	 * locale (string) - language to use, default is english
	 */

	// our plugin constructor
	var multiField = function( elem, options ){
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;
		// Localization
		this.localize_i18n={
        "multiField": {
          "messages": {
            "removeConfirmation": "Вы точно хотите удалить эту секцию?"
          }
        }
      };

		// This next line takes advantage of HTML5 data attributes
		// to support customization of the plugin on a per-element
		// basis. For example,
		// <div class=item' data-mfield-options='{"section":".group"}'></div>
		this.metadata = this.$elem.data( 'mfield-options' );
	};

	// the plugin prototype
	multiField.prototype = {

		defaults: {
			max: 0,
			locale: 'default'
		},
		
		init: function() {
			var $this = this; //Plugin object
			// Introduce defaults that can be extended either
			// globally or using an object literal.
			this.config = $.extend({}, this.defaults, this.options,
				this.metadata);

			// Load localization object
			if(this.config.locale !== 'default'){
				$this.localize_i18n = this.config.locale;
		    }

			// Hide 'Remove' buttons if only one section exists
			if(this.getSectionsCount()<2) {
				$(this.config.btnRemove, $(this.config.sectionAdd)).hide();
			}
			// Add section
			this.$elem.on('click',this.config.btnAdd,function(e){
				e.preventDefault();
				$this.cloneSection();
			});

			// Remove section
			this.$elem.on('click',this.config.btnRemove,function(e){
				e.preventDefault();
				var currentSection=$(e.target.closest($this.config.section));
				$this.removeSection(currentSection);
			});

			return this;
		},


		/*
		 * Add new section
		 */
		cloneSection : function() {
			// Allow to add only allowed max count of sections
			if((this.config.max!==0)&&(this.getSectionsCount()+1)>this.config.max){
				return false;
			}

			// Clone last section
			var newChild = $(this.config.section, this.$elem).last().clone().attr('style', '').attr('id', '').fadeIn('fast');

			// In new fields we remove selected options
            $("select option:selected", newChild).remove();

			// Clear input values
			$('input[type!="radio"]:not(.multiprotect),textarea,select:not(.multiprotect)', newChild).each(function () {
				$(this).val('');
			});

            // Replace IDs and Names input values
            $('input[type!="radio"],textarea,select', newChild).each(function () {
                var name=$(this).attr('name');
                $(this).attr('name',name.replace(/([0-9]+)/g,1*(name.match(/([0-9]+)/g))+1));
                var id=$(this).attr('id');
                if(id) $(this).attr('id',id.replace(/([0-9]+)/g,1*(id.match(/([0-9]+)/g))+1));
            });

			// Fix radio buttons: update name [i] to [i+1]
			newChild.find('input[type="radio"]').each(function(){var name=$(this).attr('name');$(this).attr('name',name.replace(/([0-9]+)/g,1*(name.match(/([0-9]+)/g))+1));});
			// Reset radio button selection
			$('input[type=radio]',newChild).attr('checked', false);

			// Clear images src with reset-image-src class
			$('img.reset-image-src', newChild).each(function () {
				$(this).attr('src', '');
			});
			
			// Delete images src with delete-image class
			$('img.delete-image', newChild).each(function () {
				$(this).remove();
			});

			// Append new section
			this.$sectionAdd = $(this.config.sectionAdd);
			this.$sectionAdd.append(newChild);
			this.$elem = this.$sectionAdd;
			//this.$elem.append(newChild);

			// Show 'remove' button
			//$(this.config.btnRemove, this.$elem).show();
			$(this.config.btnRemove, this.$sectionAdd).show();
		},

		/*
		 * Remove existing section
		 */
		removeSection : function(section){
			if (confirm(this.localize_i18n.multiField.messages.removeConfirmation)){
				var sectionsCount = this.getSectionsCount();

				if(sectionsCount<=2){
					//$(this.config.btnRemove,this.$elem).hide();
					$(this.config.btnRemove,this.$sectionAdd).hide();
				}
				section.slideUp('fast', function () {$(this).detach();});
			}
		},

		/*
		 * Get sections count
		 */
		getSectionsCount: function(){
			return $(this.config.sectionAdd).children(this.config.section).length;
		}

	};

	multiField.defaults = multiField.prototype.defaults;

	$.fn.multifield = function(options) {
		return this.each(function() {
			new multiField(this, options).init();
		});
	};



})( jQuery, window, document );
