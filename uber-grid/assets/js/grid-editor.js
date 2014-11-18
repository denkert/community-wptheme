// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  jQuery(function($) {
    var AutoEditor, CategoriesView, Cell, CellEditorBase, CellTemplate, ImageSelector, LayoutSelector, ManualEditor, TemplateLayoutSelector, autoEditor, manualEditor, renameCellInputs, _ref, _ref1, _ref2, _ref3, _ref4, _ref5, _ref6, _ref7, _ref8;
    CategoriesView = (function(_super) {
      __extends(CategoriesView, _super);

      function CategoriesView() {
        this.onLinkClick = __bind(this.onLinkClick, this);
        this.initialize = __bind(this.initialize, this);
        _ref = CategoriesView.__super__.constructor.apply(this, arguments);
        return _ref;
      }

      CategoriesView.prototype.initialize = function(params) {
        CategoriesView.__super__.initialize.call(this, params);
        this.links = this.$el.find('.ubergrid-tabs li a');
        this.panels = this.$el.find('.ubergrid-panels li');
        this.links.on('click', this.onLinkClick);
        this.panels.eq(0).addClass('ubergrid-current');
        return this.links.eq(0).parent().addClass('ubergrid-current');
      };

      CategoriesView.prototype.onLinkClick = function(event) {
        var index;
        event.preventDefault();
        this.panels.removeClass('ubergrid-current');
        index = this.links.index(event.target);
        this.panels.eq(index).addClass('ubergrid-current');
        this.links.parent().removeClass('ubergrid-current');
        return $(event.target).parent().addClass('ubergrid-current');
      };

      return CategoriesView;

    })(wp.media.View);
    new CategoriesView({
      el: $('#grid_layout')
    });
    new CategoriesView({
      el: $('#grid_extras')
    });
    renameCellInputs = function() {
      return $("#cells .cell").each(function(index, cell) {
        return $(cell).find("*:input").each(function(inputIndex, input) {
          var name;
          name = $(input).attr("name");
          if (name) {
            return $(input).attr("name", name.replace(/^cells\[\d*\]/, "cells[" + index + "]"));
          }
        });
      });
    };
    ImageSelector = (function(_super) {
      __extends(ImageSelector, _super);

      function ImageSelector() {
        this.deleteImageClicked = __bind(this.deleteImageClicked, this);
        this.selectImageClicked = __bind(this.selectImageClicked, this);
        this.initialize = __bind(this.initialize, this);
        _ref1 = ImageSelector.__super__.constructor.apply(this, arguments);
        return _ref1;
      }

      ImageSelector.prototype.initialize = function(options) {
        var _this = this;
        ImageSelector.__super__.initialize.call(this, options);
        this.layoutSelector = options.layoutSelector;
        this.$selectImage = this.$el.find('button.select-image');
        this.$image = this.$el.find('img');
        this.$input = this.$el.find('input');
        this.$selectImage.click(this.selectImageClicked);
        this.$actionsWrapper = this.$el.find('.actions-wrapper');
        this.$deleteImage = this.$el.find('.image-delete');
        this.$overlay = this.$el.find('.overlay');
        this.$deleteImage.click(this.deleteImageClicked);
        this.$el.hover((function() {
          if (_this.$image.size() > 0) {
            _this.$actionsWrapper.fadeIn('fast');
            return _this.$overlay.fadeIn('fast');
          }
        }), function() {
          if (_this.$image.size() > 0) {
            _this.$actionsWrapper.fadeOut('fast');
            return _this.$overlay.fadeOut('fast');
          }
        });
        if (this.$image.size() === 0) {
          return this.$deleteImage.fadeOut('fast');
        } else {
          this.$actionsWrapper.fadeOut('fast');
          return this.$overlay.fadeOut('fast');
        }
      };

      ImageSelector.prototype.selectImageClicked = function(e) {
        var flow, id, loadNewImage, setImageField,
          _this = this;
        e.preventDefault();
        setImageField = function(imageId) {
          return _this.$input.val(imageId);
        };
        loadNewImage = function(selection) {
          if (_this.$image.size() === 0) {
            _this.$image = $("<img />").prependTo(_this.$el);
          }
          _this.$image.attr("src", selection.attributes.url);
          _this.$image.attr("class", "r1c1");
          _this.$deleteImage.fadeIn("fast");
          _this.$actionsWrapper.fadeOut('fast');
          _this.$overlay.fadeOut('fast');
          return $.post('admin-ajax.php', {
            action: "uber_grid_generate_thumbnail",
            id: selection.id,
            format: _this.layoutSelector.getCurrentLayout()
          }, function(response) {
            if (response.url) {
              return _this.$image.attr("src", response.url);
            }
          });
        };
        flow = wp.media({
          title: "Select an image",
          library: {
            type: "image"
          },
          button: {
            text: "Select Image"
          },
          multiple: false
        }).open();
        id = this.$input.val();
        if (id && id !== '') {
          flow.state().get('selection').reset([wp.media.model.Attachment.get(id)]);
        }
        flow.state().set("display", false);
        return flow.state().on("select", function(el) {
          var selection;
          selection = this.get("selection").single();
          setImageField(selection.id);
          return loadNewImage(selection);
        });
      };

      ImageSelector.prototype.deleteImageClicked = function(event) {
        event.preventDefault();
        this.$image.remove();
        this.$image = this.$el.find('img');
        this.$input.val('');
        this.$overlay.fadeOut('fast');
        this.$actionsWrapper.fadeIn('fast');
        this.$deleteImage.fadeOut('fast');
        return false;
      };

      return ImageSelector;

    })(Backbone.View);
    LayoutSelector = (function(_super) {
      __extends(LayoutSelector, _super);

      function LayoutSelector() {
        this.getImageSize = __bind(this.getImageSize, this);
        this.onLayoutChanged = __bind(this.onLayoutChanged, this);
        this.initialize = __bind(this.initialize, this);
        _ref2 = LayoutSelector.__super__.constructor.apply(this, arguments);
        return _ref2;
      }

      LayoutSelector.prototype.initialize = function() {
        LayoutSelector.__super__.initialize.apply(this, arguments);
        this.$options = this.$el.find('.layouts li');
        this.layouts = {
          "r1c1-io": "r1c1",
          "r1c2-ir": "r1c1",
          "r1c2-il": "r1c1",
          "r2c1-it": "r1c1",
          "r2c1-ib": "r1c1",
          "r2c2-io": "r2c2",
          "r2c2-it": "r1c2",
          "r2c2-ib": "r1c2",
          "r2c2-il": "r2c1",
          "r2c2-ir": "r2c1",
          "r1c2-io": "r1c2",
          "r2c1-io": "r2c1"
        };
        this.$options.removeClass("selected");
        if (this.$el.find("input").val()) {
          this.$el.find(".layouts li." + this.$el.find("input").val()).addClass("selected");
        }
        return this.$options.click(this.onLayoutChanged);
      };

      LayoutSelector.prototype.onLayoutChanged = function(event) {
        var clicked;
        clicked = $(event.target).parent();
        this.$el.find('.layouts li').removeClass("selected");
        clicked.addClass("selected");
        this.$el.find("input").val(clicked.attr("class").split(/\s+/)[0]);
        this.$el.removeClass(this.currentClass);
        this.$el.addClass(this.currentClass = this.getImageSize());
        return this.trigger('change');
      };

      LayoutSelector.prototype.getImageSize = function() {
        return this.layouts[this.$el.find("input").val()];
      };

      return LayoutSelector;

    })(Backbone.View);
    TemplateLayoutSelector = (function(_super) {
      __extends(TemplateLayoutSelector, _super);

      function TemplateLayoutSelector() {
        this.onDeleteClicked = __bind(this.onDeleteClicked, this);
        this.initialize = __bind(this.initialize, this);
        _ref3 = TemplateLayoutSelector.__super__.constructor.apply(this, arguments);
        return _ref3;
      }

      TemplateLayoutSelector.prototype.initialize = function(options) {
        TemplateLayoutSelector.__super__.initialize.call(this, options);
        if (options.first) {
          return this.$el.find('h3 a').remove();
        } else {
          return this.$el.find('h3 a').click(this.onDeleteClicked);
        }
      };

      TemplateLayoutSelector.prototype.onDeleteClicked = function(event) {
        event.preventDefault();
        this.$el.remove();
        return this.trigger('deleted');
      };

      return TemplateLayoutSelector;

    })(LayoutSelector);
    CellEditorBase = (function(_super) {
      __extends(CellEditorBase, _super);

      function CellEditorBase() {
        this.linkModeChanged = __bind(this.linkModeChanged, this);
        this.initPickers = __bind(this.initPickers, this);
        this.reloadImages = __bind(this.reloadImages, this);
        this.toggle = __bind(this.toggle, this);
        this.initialize = __bind(this.initialize, this);
        _ref4 = CellEditorBase.__super__.constructor.apply(this, arguments);
        return _ref4;
      }

      CellEditorBase.prototype.initialize = function(opt) {
        var _this = this;
        CellEditorBase.__super__.initialize.call(this, opt);
        this.imageSelectors = [];
        this.colorPickersInitialized = false;
        if (opt.pickerOnCreate) {
          this.initPickers();
        }
        this.$el.find(".image-selector").each(function(index, el) {
          return new ImageSelector({
            el: el,
            layoutSelector: _this.layoutSelector
          });
        });
        this.$el.find("label.huge :checkbox").each(function(index, el) {
          if (!$(el).is(":checked")) {
            return $(el).parent().parent().find(".column-1, .columns-2").hide();
          }
        }).click(function() {
          return $(this).parent().parent().find(".column-1, .columns-2").toggle();
        });
        this.$el.find('.select-link-mode').change(this.linkModeChanged);
        this.linkModeChanged();
        return this.$el.find(".section.expandable label.huge").on("click", function(event) {
          $(this).parent().find(".columns-2, .column-1").toggle();
          return $(this).parent().toggleClass("expanded");
        });
      };

      CellEditorBase.prototype.toggle = function(callback) {
        this.$el.find("> .cell-content").toggle(callback);
        return this.$el.toggleClass("expanded");
      };

      CellEditorBase.prototype.reloadImages = function() {
        var ids, inputs;
        ids = [];
        inputs = view.find(".image-selector input");
        inputs.each(function(index, el) {
          if ($(el).val()) {
            return ids.push($(el).val());
          }
        });
        return $.post("admin-ajax.php?action=uber_grid_reload_images", {
          ids: ids.join(","),
          layout: this.layoutSelector.getCurrentLayout()
        }, function(response) {
          return inputs.each(function(index, el) {
            return $(el).parent().find("img").attr("src", response.srcs[index]);
          });
        });
      };

      CellEditorBase.prototype.initPickers = function() {
        if (!this.colorPickersInitialized) {
          this.$el.find(".color-picker").wpColorPicker();
          return this.colorPickersInitialized = true;
        }
      };

      CellEditorBase.prototype.linkModeChanged = function() {
        var mode;
        mode = this.$el.find(".select-link-mode").val();
        this.$el.find(".select-link-mode").parent().parent().parent().find(".link-to-url, .link-to-lightbox").hide();
        return this.$el.find(".select-link-mode").parent().parent().parent().find(".link-to-" + mode).show();
      };

      return CellEditorBase;

    })(Backbone.View);
    Cell = (function(_super) {
      __extends(Cell, _super);

      function Cell() {
        this.onTitleKeyUp = __bind(this.onTitleKeyUp, this);
        this.initialize = __bind(this.initialize, this);
        _ref5 = Cell.__super__.constructor.apply(this, arguments);
        return _ref5;
      }

      Cell.prototype.initialize = function(options) {
        var _this = this;
        Cell.__super__.initialize.call(this, options);
        this.$headerText = this.$el.find('h3 .heading');
        this.$layout = this.$el.find('.layouts');
        this.layoutSelector = new LayoutSelector({
          el: this.$el.find('.cell-layout')
        });
        this.$el.addClass(this.layoutSelector.getImageSize());
        this.$el.find(".cell-title input.cell-title-editor").keyup(this.onTitleKeyUp);
        this.$el.find("h3").on("click", function() {
          if (!_this.colorPickersInitialized) {
            _this.initPickers();
          }
          return _this.toggle();
        });
        this.$el.find(".cell-delete").click(function(event) {
          event.preventDefault();
          if (confirm("Are you sure you want to delete it?")) {
            return _this.$el.fadeOut("fast", function() {
              $(this).remove();
              return renameCellInputs();
            });
          }
        });
        this.$el.find(".cell-cancel").click(function(event) {
          event.preventDefault();
          _this.$el.find("> .cell-content").toggle();
          return $(event.target).closest("li").toggleClass("expanded");
        });
        return this.$el.find(".cell-clone").click(function(event) {
          var clone;
          event.preventDefault();
          clone = _this.$el.clone();
          clone.removeClass("expanded").find(".cell-content").hide();
          clone.find(".color-picker").show().removeClass("wp-color-picker");
          clone.find(".wp-picker-container a, .wp-picker-container input[type=button], .wp-picker-holder").remove();
          clone.find(".wp-picker-container input[type=text]").unwrap().unwrap();
          _this.$el.parent().append(clone);
          clone.find("select, textarea").each(function(index, element) {
            return $(element).val($(_this.$el.find("select, textarea")[index]).val());
          });
          renameCellInputs();
          new Cell({
            el: clone
          });
          return false;
        });
      };

      Cell.prototype.onTitleKeyUp = function(event) {
        var i, text;
        text = $(event.target).val();
        if (text) {
          return this.$headerText.text(text);
        } else {
          i = -1;
          $("#cells > li").each(function(index, element) {
            if (element === $(this).closest("li")[0]) {
              return i = index;
            }
          });
          return this.$headerText.html("Cell " + i);
        }
      };

      return Cell;

    })(CellEditorBase);
    CellTemplate = (function(_super) {
      __extends(CellTemplate, _super);

      function CellTemplate() {
        this.onAddLayoutClicked = __bind(this.onAddLayoutClicked, this);
        this.initialize = __bind(this.initialize, this);
        _ref6 = CellTemplate.__super__.constructor.apply(this, arguments);
        return _ref6;
      }

      CellTemplate.prototype.initialize = function(options) {
        var i, layout, _i, _len, _ref7;
        CellTemplate.__super__.initialize.call(this, options);
        this.$layouts = this.$el.find('.layout-list');
        this.initPickers();
        i = 0;
        this.layoutTemplate = this.$layouts.find('li:first-child')[0].outerHTML;
        _ref7 = this.$el.find('.layout-list > li');
        for (_i = 0, _len = _ref7.length; _i < _len; _i++) {
          layout = _ref7[_i];
          layout = $(layout);
          new TemplateLayoutSelector({
            el: layout,
            first: i++ === 0
          });
        }
        return this.$el.find('a.add-layout').click(this.onAddLayoutClicked);
      };

      CellTemplate.prototype.onAddLayoutClicked = function(event) {
        var layout;
        event.preventDefault();
        this.$layouts.append(layout = $(this.layoutTemplate));
        layout.find('h3 span').text(layout.find('h3 span').text().replace(/\d+/, this.$layouts.find('>li').size().toString()));
        return new TemplateLayoutSelector({
          el: layout,
          first: false
        });
      };

      return CellTemplate;

    })(CellEditorBase);
    ManualEditor = (function(_super) {
      __extends(ManualEditor, _super);

      function ManualEditor() {
        this.append = __bind(this.append, this);
        this.hide = __bind(this.hide, this);
        this.show = __bind(this.show, this);
        this.onAddCellClick = __bind(this.onAddCellClick, this);
        this.initialize = __bind(this.initialize, this);
        _ref7 = ManualEditor.__super__.constructor.apply(this, arguments);
        return _ref7;
      }

      ManualEditor.prototype.initialize = function(args) {
        ManualEditor.__super__.initialize.call(this, args);
        this.wasVisible = false;
        this.$cells = this.$el.find('#cells');
        $("#add-new-cell").click(this.onAddCellClick);
        return renameCellInputs();
      };

      ManualEditor.prototype.onAddCellClick = function(event) {
        var cell;
        event.preventDefault();
        this.$cells.append(cell = $("#cell-template .cell").clone());
        cell.find(".cell-title input.cell-title-editor").val("Cell " + (this.$cells.find('.cell').size()));
        cell.find(">h3 .heading").text(cell.find(".cell-title input.cell-title-editor").val());
        (new Cell({
          el: cell,
          pickerOnCreate: true
        })).toggle(function() {
          if ($(".cell").size() > 2) {
            return $(document).scrollTo(cell, {
              offset: -100,
              duration: 400
            });
          }
        });
        return renameCellInputs();
      };

      ManualEditor.prototype.show = function() {
        this.$el.addClass("active");
        if (!this.wasVisible) {
          this.$cells.find(".cell").each(function(index, item) {
            return new Cell({
              el: item
            });
          });
          this.$cells.sortable({
            update: renameCellInputs
          });
        }
        return this.wasVisible = true;
      };

      ManualEditor.prototype.hide = function() {
        return this.$el.removeClass("active");
      };

      ManualEditor.prototype.append = function(cells) {
        this.$cells.append(cells);
        renameCellInputs();
        return cells.each(function(index, cell) {
          return new Cell({
            el: $(cell)
          });
        });
      };

      return ManualEditor;

    })(Backbone.View);
    AutoEditor = (function(_super) {
      __extends(AutoEditor, _super);

      function AutoEditor() {
        this.hide = __bind(this.hide, this);
        this.show = __bind(this.show, this);
        this.onBuildNowClicked = __bind(this.onBuildNowClicked, this);
        this.initialize = __bind(this.initialize, this);
        _ref8 = AutoEditor.__super__.constructor.apply(this, arguments);
        return _ref8;
      }

      AutoEditor.prototype.initialize = function() {
        var _this = this;
        this.$taxFilters = this.$("#taxonomy-filters");
        this.$customFilters = this.$("#custom-field-filters");
        this.$taxFilters.find("button").click(function() {
          $(this).closest("li").remove();
          return false;
        });
        this.$customFilters.find("button").click(function(event) {
          event.preventDefault();
          return $(this).closest("li").remove();
        });
        this.$el.find('ul.filters li .button').click(function(event) {
          event.preventDefault();
          return $(this).closest('li').remove();
        });
        $("#add-taxonomy-filter").click(function(event) {
          event.preventDefault();
          $("#taxonomy-filter-template li").clone().appendTo(_this.$taxFilters.find("ul")).find("button").click(function(event) {
            event.preventDefault();
            return $(this).closest("li").remove();
          });
          return false;
        });
        $("#add-custom-field-filter").click(function(event) {
          event.preventDefault();
          return $("#custom-field-filter-template li").clone().appendTo(_this.$customFilters.find("ul")).find("button").click(function(event) {
            event.preventDefault();
            return $(this).closest("li").remove();
          });
        });
        $("#build-now").click(this.onBuildNowClicked);
        return new CellTemplate({
          el: $("#auto-cell-template")
        });
      };

      AutoEditor.prototype.onBuildNowClicked = function(event) {
        var spinner;
        event.preventDefault();
        spinner = $(this).parent().find(".spinner");
        spinner.css("display", "inline-block");
        return $.post("admin-ajax.php?action=uber_grid_build_cells", {
          data: $("#post").serialize()
        }, function(response) {
          var cellIndex, el, existingCellsCount, _i, _ref10, _ref9;
          spinner.css("display", "none");
          response = $(response);
          existingCellsCount = $('#cells li.cell').size();
          $("#cells").append(response);
          for (cellIndex = _i = _ref9 = existingCellsCount, _ref10 = existingCellsCount + response.length; _ref9 <= _ref10 ? _i <= _ref10 : _i >= _ref10; cellIndex = _ref9 <= _ref10 ? ++_i : --_i) {
            el = $($('#cells li.cell')[cellIndex - 1]);
            new Cell({
              el: el,
              pickers_on_create: false
            });
          }
          renameCellInputs();
          return $("#enable-manual-mode").click();
        });
      };

      AutoEditor.prototype.show = function() {
        return $("#auto-mode").addClass("active");
      };

      AutoEditor.prototype.hide = function() {
        return $("#auto-mode").removeClass("active");
      };

      return AutoEditor;

    })(Backbone.View);
    manualEditor = void 0;
    autoEditor = void 0;
    $("#post").submit(function(event) {
      $(this).parent().find(".spinner").show();
      return $("#uber-grid-hack").val($("#post").serialize());
    });
    $("#preview").click(function() {
      var showPreviewWindow;
      showPreviewWindow = function() {
        $("#preview-backdrop, #preview-window").show().show();
        $("#preview-content").html("");
        $.post("admin-ajax.php?action=uber_grid_preview", {
          data: $("#post").serialize()
        }, function(response) {
          $("#preview-content").css("visibility", "hidden");
          $("#preview-content").html($(response));
          $("#preview-content").css("visibility", "visible");
          return setTimeout((function() {
            return $("#preview-content .uber-grid").packery("layout");
          }), 200);
        });
        return $("#preview-close, #preview-footer-close").click(function() {
          return $("#preview-backdrop, #preview-window").hide();
        });
      };
      return showPreviewWindow();
    });
    $.post("admin-ajax.php?action=uber_grid_get_fonts", function(response) {
      var updateStylesAvailable;
      updateStylesAvailable = function(element) {
        var font, variantFound;
        font = $(element).prev().val();
        element.find("option").remove();
        variantFound = false;
        $.each(response.items, function(index, item) {
          if (item.family === font) {
            $.each(item.variants, function(index, variant) {
              return element.append($("<option />").text(variant));
            });
            return variantFound = true;
          }
        });
        if (!variantFound) {
          element.append($("<option value='light'>Light</option>"));
          element.append($("<option value='regular' selected='selected'>Regular</option>"));
          return element.append($("<option value='bold'>Bold</option>"));
        }
      };
      if (response.error) {
        $("#grid_fonts #fonts").remove();
        $("#grid_fonts .spin-wrapper").remove();
        $("#grid_fonts .inside").append("<div class=\"error\">Error loading fonts</div>");
        return;
      }
      $("#fonts-loaded").val(1);
      $.each(response.items, function(index, item) {
        var option;
        option = $("<option/>").text(item.family);
        return $("#grid_fonts select[role=font]").append(option);
      });
      $("#grid_fonts select[role=font]").each(function(index, element) {
        return $(element).find("option").each(function(index, option) {
          if ($(option).attr('value') === $(element).attr("data-font")) {
            return $(option).attr("selected", "selected");
          }
        });
      });
      $("#grid_fonts select[role=style]").each(function(index, element) {
        updateStylesAvailable($(element));
        return $(element).find("option").each(function(index, option) {
          if ($(option).attr('value') === $(element).attr("data-font")) {
            return $(option).attr("selected", "selected");
          }
        });
      });
      $("#grid_fonts select[role=font]").change(function() {
        return updateStylesAvailable($(this).next());
      });
      return $("#grid_fonts .spin-wrapper").animate({
        opacity: 0
      }, function() {
        $(this).remove();
        return $("#grid_fonts #fonts").animate({
          opacity: 1
        });
      });
    });
    manualEditor = new ManualEditor({
      el: $('#manual-mode')
    });
    autoEditor = new AutoEditor({
      el: $('#auto-mode')
    });
    if ($("#current-mode").val() === "auto") {
      autoEditor.show();
    } else {
      manualEditor.show();
    }
    $("#enable-manual-mode").click(function() {
      $("#enable-auto-mode").removeClass("nav-tab-active");
      $(this).addClass("nav-tab-active");
      $("#current-mode").val("manual");
      manualEditor.show();
      return autoEditor.hide();
    });
    $("#enable-auto-mode").click(function() {
      $("#enable-manual-mode").removeClass("nav-tab-active");
      $("#manual-mode").removeClass("active");
      $(this).addClass("nav-tab-active");
      $("#auto-mode").addClass("active");
      $("#current-mode").val("auto");
      manualEditor.hide();
      return autoEditor.show();
    });
    return $("#publish").removeAttr("disabled");
  });

}).call(this);
