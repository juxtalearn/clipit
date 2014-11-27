var getCaretPixelPos = function ($node, offsetx, offsety){
    offsetx = offsetx || 0;
    offsety = offsety || 0;

    var nodeLeft = 0,
        nodeTop = 0;
    if ($node){
        nodeLeft = $node.offsetLeft;
        nodeTop = $node.offsetTop;
        nodeTop = $($node).offset().top;
        nodeTop = nodeTop - $(".elgg-layout-one-sidebar .elgg-main").offset().top;
    }

    var pos = {left: 0, top: 0};

    if (document.selection){
        var range = document.selection.createRange();
        pos.left = range.offsetLeft + offsetx - nodeLeft + 'px';
        pos.top = range.offsetTop + offsety - nodeTop + 'px';
    }else if (window.getSelection){
        var idoc= $node.contentDocument || $node.contentWindow.document;
        var sel = idoc.getSelection();
        var range = sel.getRangeAt(0).cloneRange();
        try{
            range.setStart(range.startContainer, range.startOffset-1);
        }catch(e){}
        var rect = range.getBoundingClientRect();
        if (range.endOffset == 0 || range.toString() === ''){
            // first char of line
            if (range.startContainer == $node){
                // empty div
                if (range.endOffset == 0){
                    pos.top = '0px';
                    pos.left = '0px';
                }else{
                    // firefox need this
                    var range2 = range.cloneRange();
                    range2.setStart(range2.startContainer, 0);
                    var rect2 = range2.getBoundingClientRect();
                    pos.left = rect2.left + offsetx - nodeLeft + 'px';
                    pos.top = rect2.top + rect2.height + offsety - nodeTop + 'px';
                }
            }else{
                pos.top = range.startContainer.offsetTop+'px';
                pos.left = range.startContainer.offsetLeft+'px';
            }
        }else{
            pos.left = rect.left + rect.width + offsetx + nodeLeft + 'px';
            pos.top = rect.top + offsety + nodeTop +  30 +'px';
        }
    }
    return pos;
};



/**
 * GetTextAreaXandY
 * @param e
 */
function getTextAreaXandY(e) {

    // Don't do anything if key pressed is left arrow
    if (e.which == 37) return;

    // Save selection start
    var selection = $(this).getSelection();
    var index = selection.start;

    //alert(selection.start);
    //alert(selection.end);
    // Copy text to div
    $(this).blur();
    $("div").text($(this).val());

    // Get current character
    $(this).setSelection(index, index + 1);
    currentcharacter = $(this).getSelection().text;

    // Get previous character
    $(this).setSelection(index - 1, index)
    previouscharacter = $(this).getSelection().text;

    var start, endchar;
    var end = 0;
    var range = rangy.createRange();

    // If current or previous character is a space or a line break, find the next word and wrap it in a span
    var linebreak = previouscharacter.match(/(\r\n|\n|\r)/gm) == undefined ? false : true;

    if (previouscharacter == ' ' || currentcharacter == ' ' || linebreak) {
        i = index + 1; // Start at the end of the current space        
        while (endchar != ' ' && end < $(this).val().length) {
            i++;
            $(this).setSelection(i, i + 1)
            var sel = $(this).getSelection();
            endchar = sel.text;
            end = sel.start;
        }

        range.setStart($("div")[0].childNodes[0], index);
        range.setEnd($("div")[0].childNodes[0], end);
        var nextword = range.toHtml();
        range.deleteContents();
        var position = $("<span id='nextword'>" + nextword + "</span>")[0];
        range.insertNode(position);
        var nextwordtop = $("#nextword").position().top;
    }

    // Insert `#caret` at the position of the caret
    range.setStart($("div")[0].childNodes[0], index);
    var caret = $("<span id='caret'></span>")[0];
    range.insertNode(caret);
    var carettop = $("#caret").position().top;

    // If preceding character is a space, wrap it in a span
    if (previouscharacter == ' ') {
        range.setStart($("div")[0].childNodes[0], index - 1);
        range.setEnd($("div")[0].childNodes[0], index);
        var prevchar = $("<span id='prevchar'></span>")[0];
        range.insertNode(prevchar);
        var prevchartop = $("#prevchar").position().top;
    }

    // Set textarea selection back to selection start
    $(this).focus();
    $(this).setSelection(selection.start, selection.end);

    // If the top value of the previous character span is not equal to the top value of the next word,
    // there must have been some wrapping going on, the previous character was a space, so the wrapping
    // would have occured after this space, its safe to assume that the left and top value of `#nextword`
    // indicate the caret position
    if (prevchartop != undefined && prevchartop != nextwordtop) {
        $("label").text('X: ' + $("#nextword").position().left + 'px, Y: ' + $("#nextword").position().top);
        $('ul').css('left', ($("#nextword").position().left) + 'px');
        $('ul').css('top', ($("#nextword").position().top + 13) + 'px');
    }
    // if not, then there was no wrapping, we can take the left and the top value from `#caret`    
    else {
        $("label").text('X: ' + $("#caret").position().left + 'px, Y: ' + $("#caret").position().top);
        $('ul').css('left', ($("#caret").position().left) + 'px');
        $('ul').css('top', ($("#caret").position().top + 14) + 'px');
    }

    $('ul').css('display', 'block');

}

/**
 */
/*global tinymce, jQuery */



    var AutoComplete_wysihtml5 = function (ed, editor, options) {
        this.editor = ed;
        this.wysihtmlEditor = editor,
        this.options = $.extend({}, {
            source: [],
            delay: 500,
            queryBy: 'name',
            items: 10
        }, options);

        this.matcher = this.options.matcher || this.matcher;
        this.renderDropdown = this.options.renderDropdown || this.renderDropdown;
        this.render = this.options.render || this.render;
        this.insert = this.options.insert || this.insert;
        this.highlighter = this.options.highlighter || this.highlighter;

        this.query = '';
        this.hasFocus = true;

        this.renderInput();

        //this.bindEvents();
    };

    AutoComplete_wysihtml5.prototype = {

        constructor: AutoComplete_wysihtml5,

        renderInput: function () {
            var rawHtml =  '<span id="autocomplete">' +
                '<span id="autocomplete-delimiter">' + this.options.delimiter + '</span>' +
                '<span id="autocomplete-searchtext"><span class="dummy">\uFEFF</span></span>' +
                '</span>';

            //this.wysihtmlEditor.setValue(rawHtml, true);
            this.editor.focus();
            //this.editor.selection.select(this.editor.selection.dom.select('span#autocomplete-searchtext span')[0]);
            //this.editor.selection.collapse(0);
        },



        rteKeyUp: function (e) {
            switch (e.which || e.keyCode) {
                //DOWN ARROW
                case 40:
                //UP ARROW
                case 38:
                //SHIFT
                case 16:
                //CTRL
                case 17:
                //ALT
                case 18:
                    break;

                //BACKSPACE
                case 8:
                    if (this.query === '') {
                        this.cleanUp(true);
                    } else {
                        this.lookup();
                    }
                    break;

                //TAB
                case 9:
                //ENTER
                case 13:
                    var item = (this.$dropdown !== undefined) ? this.$dropdown.find('li.active') : [];
                    if (item.length) {
                        this.select(item.data());
                        this.cleanUp(false);
                    } else {
                        this.cleanUp(true);
                    }
                    break;

                //ESC
                case 27:
                    this.cleanUp(true);
                    break;

                default:
                    this.lookup();
            }
        },

        rteKeyDown: function (e) {
            switch (e.which || e.keyCode) {
                //TAB
                case 9:
                //ENTER
                case 13:
                //ESC
                case 27:
                    e.preventDefault();
                    break;

                //UP ARROW
                case 38:
                    e.preventDefault();
                    if (this.$dropdown !== undefined) {
                        this.highlightPreviousResult();
                    }
                    break;
                //DOWN ARROW
                case 40:
                    e.preventDefault();
                    if (this.$dropdown !== undefined) {
                        this.highlightNextResult();
                    }
                    break;
            }

            e.stopPropagation();
        },

        rteClicked: function (e) {
            var $target = $(e.target);

            if (this.hasFocus && $target.parent().attr('id') !== 'autocomplete-searchtext') {
                this.cleanUp(true);
            }
        },

        rteLostFocus: function (ed, e) {
            if (this.hasFocus) {
                this.cleanUp(true);
            }
        },

        lookup: function () {
            this.query = $.trim($(this.editor.getBody()).find("#autocomplete-searchtext").text()).replace('\ufeff', '');

            if (this.$dropdown === undefined) {
                this.show();
            }

            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout($.proxy(function () {
                // Added delimiter parameter as last argument for backwards compatibility.
                var items = $.isFunction(this.options.source) ? this.options.source(this.query, $.proxy(this.process, this), this.options.delimiter) : this.options.source;
                if (items) {
                    this.process(items);
                }
            }, this), this.options.delay);
        },

        matcher: function (item) {
            return ~item[this.options.queryBy].toLowerCase().indexOf(this.query.toLowerCase());
        },

        sorter: function (items) {
            var beginswith = [],
                caseSensitive = [],
                caseInsensitive = [],
                item;

            while ((item = items.shift()) !== undefined) {
                if (!item[this.options.queryBy].toLowerCase().indexOf(this.query.toLowerCase())) {
                    beginswith.push(item);
                } else if (~item[this.options.queryBy].indexOf(this.query)) {
                    caseSensitive.push(item);
                } else {
                    caseInsensitive.push(item);
                }
            }

            return beginswith.concat(caseSensitive, caseInsensitive);
        },

        highlighter: function (text) {
            return text.replace(new RegExp('(' + this.query + ')', 'ig'), function ($1, match) {
                return '<strong>' + match + '</strong>';
            });
        },

        show: function () {
            var rtePosition = $(this.editor.getContainer()).offset(),
                contentAreaPosition = $(this.editor.getContentAreaContainer()).position(),
                nodePosition = $(this.editor.dom.select('span#autocomplete')).position(),
                top = rtePosition.top + contentAreaPosition.top + nodePosition.top + $(this.editor.selection.getNode()).innerHeight() - $(this.editor.getDoc()).scrollTop() + 5,
                left = rtePosition.left + contentAreaPosition.left + nodePosition.left;

            this.$dropdown = $(this.renderDropdown())
                .css({ 'top': top, 'left': left });

            $('body').append(this.$dropdown);

            this.$dropdown.on('click', $.proxy(this.autoCompleteClick, this));
        },

        process: function (data) {
            if (!this.hasFocus) {
                return;
            }
            var _this = this,
                result = [],
                items = $.grep(data, function (item) {
                    return _this.matcher(item);
                });

            items = _this.sorter(items);

            items = items.slice(0, this.options.items);

            $.each(items, function (i, item) {
                var $element = $(_this.render(item));

                $element.html($element.html().replace($element.text(), _this.highlighter($element.text())));

                $.each(items[i], function (key, val) {
                    $element.attr('data-' + key, val);
                });

                result.push($element[0].outerHTML);
            });

            if (result.length) {
                this.$dropdown.html(result.join('')).show();
            } else {
                this.$dropdown.hide();
            }
        },

        renderDropdown: function () {
            return '<ul class="rte-autocomplete dropdown-menu"><li class="loading"></li></ul>';
        },

        render: function (item) {
            return '<li>' +
                '<a href="javascript:;"><span>' + item.name + '</span></a>' +
                '</li>';
        },

        autoCompleteClick: function (e) {
            var item = $(e.target).closest('li').data();
            if (!$.isEmptyObject(item)) {
                this.select(item);
                this.cleanUp(false);
            }
            e.stopPropagation();
            e.preventDefault();
        },

        highlightPreviousResult: function () {
            var currentIndex = this.$dropdown.find('li.active').index(),
                index = (currentIndex === 0) ? this.$dropdown.find('li').length - 1 : --currentIndex;

            this.$dropdown.find('li').removeClass('active').eq(index).addClass('active');
        },

        highlightNextResult: function () {
            var currentIndex = this.$dropdown.find('li.active').index(),
                index = (currentIndex === this.$dropdown.find('li').length - 1) ? 0 : ++currentIndex;

            this.$dropdown.find('li').removeClass('active').eq(index).addClass('active');
        },

        select: function (item) {
            this.editor.focus();
            var selection = this.editor.dom.select('span#autocomplete')[0];
            this.editor.dom.remove(selection);
            this.editor.execCommand('mceInsertContent', false, this.insert(item) + '&nbsp;');
        },

        insert: function (item) {
            return '<span>' + item.name + '</span>';
        },

        cleanUp: function (rollback) {
            //this.unbindEvents();
            this.hasFocus = false;

            if (this.$dropdown !== undefined) {
                this.$dropdown.remove();
                delete this.$dropdown;
            }

            if (rollback) {
                var text = this.query,
                    $selection = $(this.editor.dom.select('span#autocomplete')),
                    replacement = $('<p>' + this.options.delimiter + text + '</p>')[0].firstChild,
                    focus = $(this.editor.selection.getNode()).offset().top === ($selection.offset().top + (($selection.outerHeight() - $selection.height()) / 2));

                this.editor.dom.replace(replacement, $selection[0]);

                if (focus) {
                    this.editor.selection.select(replacement);
                    this.editor.selection.collapse();
                }
            }
        }

    };

//    tinymce.create('tinymce.plugins.Mention', {
//
//        init: function (ed, url) {
//
//            var autoComplete,
//                autoCompleteData = ed.getParam('mentions');
//
//            // If the delimiter is undefined set default value to ['@'].
//            // If the delimiter is a string value convert it to an array. (backwards compatibility)
//            autoCompleteData.delimiter = (autoCompleteData.delimiter !== undefined) ? !$.isArray(autoCompleteData.delimiter) ? [autoCompleteData.delimiter] : autoCompleteData.delimiter : ['@'];
//
//            function prevCharIsSpace() {
//                var start = ed.selection.getRng(true).startOffset,
//                    text = ed.selection.getRng(true).startContainer.data || '',
//                    charachter = text.substr(start - 1, 1);
//
//                return (!!$.trim(charachter).length) ? false : true;
//            }
//
//            ed.on('keypress', function (e) {
//                var delimiterIndex = $.inArray(String.fromCharCode(e.which || e.keyCode), autoCompleteData.delimiter);
//                if (delimiterIndex > -1 && prevCharIsSpace()) {
//                    if (autoComplete === undefined || (autoComplete.hasFocus !== undefined && !autoComplete.hasFocus)) {
//                        e.preventDefault();
//                        // Clone options object and set the used delimiter.
//                        autoComplete = new AutoComplete_wysihtml5(ed, $.extend({}, autoCompleteData, { delimiter: autoCompleteData.delimiter[delimiterIndex] }));
//                    }
//                }
//            });
//
//        },
//
//    });

