<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/12/2014
 * Last update:     03/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
//<script>
    elgg.provide('clipit.tricky_topic');

    clipit.tricky_topic.init = function () {
        $(".input-tag").autocomplete(clipit.tricky_topic.tagsAutocomplete());
        $(document).on("click", "#add-tag", clipit.tricky_topic.addTag);
        $(document).on("keypress", ".form-add-tags input[type=text]", clipit.tricky_topic.onKeypressTag);
        $(document).on(clipit.tricky_topic.onReflectionItemShow(), ".reflection-item label");
        $(document).on("click", ".add-input", clipit.tricky_topic.addInput);
        $(document).on("click", ".remove-input", clipit.tricky_topic.removeInput);
        $(document).on("click", ".show-examples", clipit.tricky_topic.showExamples);
        $(document).on("change", ".clone-input input:file", clipit.tricky_topic.checkFileAdd);
        $(document).on("click", "#removeButton", clipit.tricky_topic.removeInputField);
        $(document).on("click", 'a.recommended_item', clipit.tricky_topic.selectRecommendation);
        $(document).on("focusout", ".form-add-tags input[type=text]", clipit.tricky_topic.onFocusOut);
        $(document).on("focusin", ".form-add-tags input[type=text]", clipit.tricky_topic.onFocusIn);

    };
    elgg.register_hook_handler('init', 'system', clipit.tricky_topic.init);

    clipit.tricky_topic.tagsAutocomplete = function () {
        return {
            source: function (request, response) {
                elgg.getJSON(
                    "ajax/view/tricky_topics/tags/search", {
                        data: {q: request.term},
                        success: function (data) {
                            response(data);
                        }
                    }
                );
            },
            open: function () {
                $(this).data("ui-autocomplete").menu.element
                    .addClass("tags-autocomplete")
                    .css("display", "inline-block");
            },
            select: function (event, ui) {
                event.preventDefault();
                this.value = ui.item.label;

                // elgg.system_message(this.value);
//            $.post(elgg.get_site_url() +  'ajax/view/recommendation/tricky_topic', {action: 'checkOnto', inputvalue: this.value}, function (data, status){
//                    elgg.system_message(data);

            },
            focus: function (event, ui) {
                event.preventDefault();
                this.value = ui.item.label;
            },
            minLength: 2
        };
    };

    clipit.tricky_topic.link = function (e) {
        $(this).toggle();
        var content = e.data.content,
            container = $(this).closest("td").find(".list-tricky-topic");
        container.toggle().html(content);
        container.find("form .input-entity-id").val($(this).attr("id"));
        container.find('form option').each(function () {
            var text = $(this).text();
            if (text.length > 30)
                $(this).val(text).text(text.substr(0, 30) + '...')
        });
    };

    clipit.tricky_topic.onFocusIn = function () {
        var $input = $(this);
        $input.attr('data-focusin', $input.val());
    };

    clipit.tricky_topic.onFocusOut = function () {
        var $input = $(this),
            focusInValue = $input.attr('data-focusin'),
            focusOutValue = $input.val();
        if (focusOutValue.length > 0) {
            if (focusInValue !== focusOutValue) {
                updateList();
                if ($input.parent('.form-group').is(':last-child')) {
                    clipit.tricky_topic.addTag();
                }
            }
        } else {
            if (!$input.parent('.form-group').is(':last-child')) {
                //trigger remove field
                $input.parent('.form-group').find('#removeButton').click();
            }
        }
    };

    function updateList() {
        function update($list, data_array) {
            var oldItems = $('li .recommended_item'),
                newItems = [];
            $list.find('li').addClass('old');
            data_array.forEach(function (d) {
                addRecommendationItem(d, newItems, !isInArray(d, oldItems));
            });
            newItems = $.grep(newItems, function (d) {
                return !$(d).hasClass('old');
            });
            newItems.sort(function (a, b) {
                var rank1 = a.find('a').attr('data-rank'),
                    rank2 = b.find('a').attr('data-rank');
                return rank1 - rank2 > 0 ? -1 : rank1 - rank2 < 0 ? 1 : 0;
            });
            $list.empty()
                .append(newItems)
                .fadeIn('fast', function () {
                    highlightNewItems($list);
                });
        }

        function highlightNewItems($list) {
            var $recommendationsToHighlight = $list.find('.new a');
            $recommendationsToHighlight.addClass('highlight-recommendation', 500, 'easeInBack');
            setTimeout(function () {
                $recommendationsToHighlight.removeClass('highlight-recommendation', 500, 'easeOutBack');
            }, 3000);
        }

        function addRecommendationItem(recommendation, array, newItem) {
            var $li = $('<li>');
            if (newItem) {
                $li.addClass('new');
            }
            $('<a>')
                .attr('data-key', recommendation.key)
                .attr('data-rank', recommendation.rank)
                .addClass('recommended_item')
                .text(recommendation.label).appendTo($li);
            array.push($li);
            return $li;
        }

        function isInArray(recommendation, $array) {
            for (var i = 0; i < $array.length; i++) {
                var $element = $array.eq(i),
                    key = $element.data('key');

                if (key == recommendation.key) {
                    return true;
                }
            }
            return false;
        }

        var inputArray = [];
        $('input[name^=tag]').each(function () {
            var value = $(this).val();
            if (value.length > 0) {
                inputArray.push(value);
            }
        });

        var $recommList = $('#recommendations');
        if (inputArray.length == 0) {
            $recommList.empty();
            return;
        }

        $recommList.addClass('loading');
        $(document).off("click", 'a.recommended_item');
        $('#loading-spinner').show('blind');
        $.ajax({
            url: elgg.get_site_url() + 'ajax/view/recommendation/tricky_topic',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'getRecommendation',
                input: inputArray
            },
            success: function (data, status, jqXHR) {
                $('#recommendations').fadeOut('fast', function () {
                    update($('#recommendations'), data);
                });
            },
            complete: function(jqXHR, textStatus){
                $('#loading-spinner').hide('blind');
                $('#recommendations').removeClass('loading');
                $(document).on("click", 'a.recommended_item', clipit.tricky_topic.selectRecommendation);
            }
        });
//            //DEBUG create dummy data
////            if (data_array.length == 0) {
////                for (var i = 0; i < 15; i++) {
////                    var key = Math.round(Math.random() * 30);
////                    data_array.push({
////                        label: 'tag_' + key,
////                        rank: Math.random() * 2,
////                        key: key
////                    });
////                }
////            }
    }


    clipit.tricky_topic.addTag = function () {
        var container = $(".form-add-tags"),
            lastInput = container.find(".input-tag:last");
        if (typeof lastInput.val() !== 'undefined' && lastInput.val().length > 0) {

//            updateList();
            container.append(<?php echo json_encode(elgg_view("tricky_topics/tags/add"));?>);

            container.find(".input-tag:last").focus().autocomplete(clipit.tricky_topic.tagsAutocomplete());
        }
    };


    clipit.tricky_topic.selectRecommendation = function () {

        var container = $(".form-add-tags");
        container.find('.input-tag:last').val($(this).html());

        container.append(<?php echo json_encode(elgg_view("tricky_topics/tags/add"));?>);
        updateList();
    };


    clipit.tricky_topic.removeInputField = function () {
        var $parent = $(this).parent(".form-group");
        if (!$parent.is(':last-child')) {
            $parent.animate({height: 'hide'}, {
                complete: function () {
                    $parent.remove();
                    updateList();
                }
            });
        }
    };

    clipit.tricky_topic.onKeypressTag = function (e) {
        var last_char = String.fromCharCode(e.which);


        if (e.keyCode == 13 || last_char == ',') {
            e.preventDefault();
            $(this).closest('form').find('#add-tag').click();
            return false;
        }
    };
    clipit.tricky_topic.onReflectionItemShow = function () {
        return {
            mouseenter: function () {
                var container = $(this).closest(".reflection-item");
                container.find(".reflect-description").hide();
                container.find("[data-reflect_item=" + $(this).attr("id") + "]").show();
            },
            mouseleave: function () {
                var container = $(this).closest(".reflection-item");
                container.find(".reflect-description").hide();
                container.find(".reflect-description:first").show();
            }
        };
    };
    clipit.tricky_topic.addInput = function () {
        var container = $(this).closest(".form-group").find(".group-input"),
            input_clone = container.find('.clone-input:last').clone();
        input_clone.find('input').val('');
        input_clone.find('.correct').hide();
        input_clone.find('.remove-input').css('visibility', 'visible');

        if ($(this).hasClass('collapse-type')) {
            input_clone.find(".in").removeClass('in').addClass('collapse');
            $(input_clone.find('[data-toggle="collapse"]')).each(function () {
                var btn_collapse = $(this),
                    num = (btn_collapse.attr('href').replace('#collapse_', ''));
                var container_collapse = input_clone.find('#collapse_' + num);
                container_collapse.attr('id', 'collapse_' + (num + 1));
                btn_collapse.attr('href', '#collapse_' + (num + 1));
            });
            var num_panel = parseInt(input_clone.find('.panel-group').attr('id').replace('panel_', ''));
            input_clone.find('.panel-group').attr('id', 'panel_' + (num_panel + 1));
            input_clone.find('[data-toggle="collapse"]').attr('data-parent', '#panel_' + (num_panel + 1));
        }
        container.append(input_clone);
    };
    clipit.tricky_topic.checkFileAdd = function () {
        var check = $(this).closest('.clone-input').find('.correct');
        if ($(this).val() != '') {
            check.show();
        } else {
            check.hide();
        }
    };
    clipit.tricky_topic.removeInput = function () {
        $(this).closest('.clone-input').remove();
    };
    clipit.tricky_topic.showExamples = function () {
        var tr = $(this).closest("tr"),
            id = $(this).attr("id"),
            tr_example = $("[data-tag=" + id + "]");
        if (tr_example.length > 0) {
            tr_example.toggle();
            return false;
        }
        elgg.get('ajax/view/examples/summary', {
            data: {
                stumbling_block: id
            },
            success: function (content) {
                var container = $("<tr/>")
                    .attr("data-tag", id)
                    .html($('<td/>').attr("colspan", 5).html(content).css("padding", "10px"));
                tr.after(container);
            }
        });
    };


