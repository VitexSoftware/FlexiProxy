 (function(b, a, d) {
     var c = function(e) {
         this.evidenceName = e.evidence.name;
         this.evidenceUrl = e.evidence.url;
         this.csrfToken = e.csrfToken;
         this.converter = new flexibee.FormAndJson("", e.evidence.props, e.evidence.filledProps, e.dependencies);
         this.itemsDependencies = e.itemsDependencies || {};
         this.defaults = e.evidence.defaults || {};
         this.stripDependenciesOfFieldsOnFirstAmend = e.evidence.stripDependenciesOfFieldsOnFirstAmend;
         this.onAfterAmend = e.onAfterAmend;
         this.onFieldChangedBeforeAmend = e.onFieldChangedBeforeAmend;
         this.mainForm = b(e.page.form);
         this.accessibility = new flexibee.Accessibility(this.mainForm);
         this.accessibility.setFormHelper(this);
         this.items = e.items || {};
         this.itemsHelperByInputName = {};
         this.previousValues = {};
         this.previousValuesByItemsHelper = {};
         this.errorFields = {};
         this.originalByDuplicate = {};
         this.allDuplicatesByOriginal = {};
         this.ajaxManager = b.manageAjax.create("ajaxManager-" + this.evidenceName, {
             preventDoubleRequests: false,
             abortOld: true
         })
     };
     c.prototype.start = function() {
         var e = this;
         setTimeout(function() {
             e.doStart()
         }, 200);
         if (flexibee.isMobile) {
             b("form").jqmData("ajax", "false")
         }
         a.mainForm = e
     };
     c.prototype.forceAmend = function() {
         this.amendForm()
     };
     c.prototype.doStart = function() {
         var g = this;
         g.allForms = g.mainForm;
         b.each(g.items, function(i, h) {
             g.allForms = b(g.allForms).add(h.getEditForm());
             h.start(g);
             b(h.getEditForm()).allInputs().each(function() {
                 g.itemsHelperByInputName[b(this).flexibeeName()] = h
             })
         });
         b(".flexibee-dup", g.allForms).each(function() {
             var i = b(this).flexibeeName();
             var h = i.replace(/-dup\d+$/, "");
             g.originalByDuplicate[i] = h;
             if (!g.allDuplicatesByOriginal[h]) {
                 g.allDuplicatesByOriginal[h] = new Array()
             }
             g.allDuplicatesByOriginal[h].push(i)
         });

         function e(m, j, l) {
             if (l != j) {
                 a.wasChanged = true;
                 g.unifyOriginalAndDuplicates(m, l);
                 m = g.originalByDuplicate[m] || m;
                 var k = g.itemsHelperByInputName[m];
                 var h;
                 if (k) {
                     h = g.previousValuesByItemsHelper[k.getId()] || {};
                     g.previousValuesByItemsHelper[k.getId()] = h
                 } else {
                     h = g.previousValues
                 }
                 h[m] = j;
                 if (g.errorFields[m]) {
                     delete g.errorFields[m];
                     delete g.previousValues[m];
                     var i = b("#flexibee-inp-" + m);
                     if (i.parent(".flexibee-error-box").length) {
                         i.parent(".flexibee-error-box").children(".flexibee-errors").remove();
                         i.unwrap()
                     }
                 }
                 if (k && k.isEditedObjectEmpty(k.copyAndRepairItem(k.converter.convertForm2Json(k.editForm)))) {
                     return
                 }
                 if (g.onFieldChangedBeforeAmend) {
                     g.onFieldChangedBeforeAmend(m, j, l)
                 }
                 g.amendForm(m, k)
             }
         }
         b(g.allForms).allFlexBoxes().bind("change", function(k) {
             var j = b(this).flexibeeName();
             var h = k.removed === null ? null : k.removed.id;
             var i = k.added === d ? null : k.added.id;
             e(j, h, i)
         });
         b(g.allForms).allAutocompleters().not(".flexibee-suggest-psc").bind("autocompleter-change", function(k, j, h, i) {
             e(j, h, i)
         });
         b(g.allForms).allAutocompleters().filter(".flexibee-suggest-psc").bind("suggest-psc", function(k, j, h, i) {
             e(j, h, i)
         });
         b(":checkbox", g.allForms).click(function() {
             var i = b(this).flexibeeName();
             var h = b(this).is(":checked");
             b(this).val(h);
             e(i, !h, h)
         });
         b(g.allForms).allInputs().not(":checkbox").focus(function() {
             var j = b(this).flexibeeName();
             var h = b(this).val();
             g.onAmendComplete = function(k) {
                 var m = k.winstrom;
                 if (m.results && m.results.length > 0 && m.results[0].content) {
                     var n = m.results[0].content[g.evidenceName];
                     if (n && n[j]) {
                         var l = g.converter.valueJson2Form(j, n[j], n);
                         h = l
                     }
                 }
             };

             function i() {
                 var k = b(this).val();
                 e(j, h, k)
             }
             if (b(this).isDatepicker()) {
                 b(this).datepickerOnClose(i)
             }
             b(this).one("blur", i)
         });
         b(".flexibee-submit-and-new-button").show();
         var f;
         b(":submit").focus(function() {
             f = this
         });
         b("form").submit(function(h) {
             g.onAmendFullyComplete = function() {
                 var i = b(f).attr("name") === "submit-and-new";
                 a.wasChanged = false;
                 g.previousValues = {};
                 g.previousValuesByItemsHelper = {};
                 g.errorFields = {};
                 var j = g.prepareJsonForServer();
                 b.jsonAjax({
                     manager: g.ajaxManager,
                     type: "PUT",
                     url: g.evidenceUrl + ".json?no-http-errors=true&token=" + g.csrfToken,
                     data: j,
                     success: function(k) {
                         b.hideWait();
                         if (JSON.parse(k.winstrom.success)) {
                             a.wasChanged = false;
                             var l = k.winstrom.results[0].id;
                             a.location = g.evidenceUrl + (i ? ";new" : "/" + l)
                         } else {
                             g.doAmendForm(k, null, true);
                             g.onAmendFullyComplete = null;
                             b("html, body").animate({
                                 scrollTop: 0
                             }, "slow")
                         }
                     },
                     failure: function(k) {
                         b.hideWait();
                         a.alert("Došlo k fatální chybě")
                     }
                 })
             };
             if (!g.amendRunning) {
                 g.onAmendFullyComplete()
             }
             return false
         });
         g.amendRightAfterStart = true;
         g.amendForm()
     };
     c.prototype.amendForm = function(g, e) {
         var h = this;
         h.amendRunning = true;
         var f = h.prepareJsonForServer(g);
         b.jsonAjax({
             manager: h.ajaxManager,
             type: "PUT",
             url: h.evidenceUrl + ".json?dry-run=true&use-internal-id=true&no-http-errors=true&as-gui=true&token=" + h.csrfToken,
             data: f,
             success: function(i) {
                 if (h.onAmendComplete) {
                     h.onAmendComplete(i);
                     h.onAmendComplete = null
                 }
                 if (e) {
                     e.showInputsHiddenOnStart()
                 }
                 h.previousValues = {};
                 h.previousValuesByItemsHelper = {};
                 h.doAmendForm(i, e)
             },
             failure: function(i) {},
             complete: function() {
                 h.amendRightAfterStart = false;
                 if (h.onAmendFullyComplete) {
                     h.onAmendFullyComplete();
                     h.onAmendFullyComplete = null
                 }
                 h.amendRunning = false
             }
         })
     };
     c.prototype.allFieldsForProperty = function(g) {
         var h = this;
         var e = [];
         g = h.originalByDuplicate[g] || g;
         var f = false;
         if (b("#flexibee-inp-" + g + "-flexbox").length) {
             e.push(b("#flexibee-inp-" + g + "-flexbox"));
             f = true
         } else {
             if (b("#flexibee-inp-" + g).length) {
                 e.push(b("#flexibee-inp-" + g))
             }
         }
         if (h.allDuplicatesByOriginal[g]) {
             b.each(h.allDuplicatesByOriginal[g], function(k, j) {
                 var l = f ? b("#flexibee-inp-" + j + "-flexbox") : b("#flexibee-inp-" + j);
                 if (l.length) {
                     e.push(l)
                 }
             })
         }
         return e
     };
     c.prototype.unifyOriginalAndDuplicates = function(f, e) {
         var g = this;
         b(g.allFieldsForProperty(f)).each(function(h, j) {
             if (b(j).hasClass("flexibee-flexbox")) {
                 var k = b(j).attr("id");
                 b("#" + k + "_hidden").val(e);
                 var i = b("#flexibee-inp-" + f + "-flexbox_input").val();
                 b("#" + k + "_input").val(i)
             } else {
                 b(j).val(e)
             }
         })
     };
     c.prototype.prepareJsonForServer = function(i) {
         var j = this;
         var h = b.extend({}, j.defaults);
         b.each(h, function(k, l) {
             if (b.isFunction(l)) {
                 h[k] = l.call(j)
             }
         });
         var g = b.extend({}, h, j.converter.convertForm2Json(j.mainForm, i, j.previousValues, j.errorFields));
         if (j.amendRightAfterStart && j.stripDependenciesOfFieldsOnFirstAmend && !g.id) {
             var f = j.converter.dependencies;
             b.each(j.stripDependenciesOfFieldsOnFirstAmend, function(k, l) {
                 if (f[l]) {
                     b.each(f[l], function(m, n) {
                         delete g[n]
                     })
                 }
             })
         }
         b.each(j.items, function(m, l) {
             var n = l.getItemsJson(i, j.previousValuesByItemsHelper[l.getId()]);
             g[m] = n;
             g[m + "@removeAll"] = "true";
             var k = n && n.length > 0 && l.haveSignificantItems();
             if (k && j.itemsDependencies[m]) {
                 b.each(j.itemsDependencies[m], function(o, p) {
                     delete g[p]
                 })
             }
         });
         var e = {
             winstrom: {}
         };
         e.winstrom[j.evidenceName] = g;
         return e
     };
     c.prototype.doAmendForm = function(f, e, h) {
         var l = this;
         var j = f.winstrom;
         var n = l.mainForm;
         if (e) {
             var o = e.getEditForm();
             if (o.children(".flexibe-table-border")) {
                 n = o.children(".flexibee-table-border").first()
             } else {
                 n = o
             }
         }
         b(".flexibee-error-head", n).remove();
         b(".flexibee-error-box .flexibee-inp").each(function() {
             var q = b(this);
             q.parent(".flexibee-error-box").children(".flexibee-errors").remove();
             q.unwrap()
         });
         b(".flexibee-ro-input-keep").each(function() {
             var q = b(this);
             q.removeClass("flexibee-ro-input-keep").blur()
         });
         var p = JSON.parse(j.success);
         if (!p) {
             var g = '<div class="flexibee-error-head"><ul class="flexibee-errors"></ul></div>';
             if (b(n).is("table")) {
                 var m = b(n).find("col").length;
                 if (!m) {
                     m = 1
                 }
                 b(n).prepend('<tr><td colspan="' + m + '">' + g + "</td></tr>")
             } else {
                 b(n).prepend(g)
             }
             if (j.results.length > 0 && j.results[0].content) {
                 l.accessibility.update(j.results[0].content[l.evidenceName])
             }
             var k = true;
             b.each(j.results[0].errors, function(r, u) {
                 var t = b.trim(u.message.replace(/\[[^\]]*\]$/, ""));
                 b(".flexibee-errors", n).append("<li></li>").findLast("li").text(t);
                 if (u["for"]) {
                     var v = u["for"];
                     l.errorFields[v] = true;
                     var q = b("#flexibee-inp-" + v);
                     if (!q.length) {
                         q = b("#flexibee-inp-" + v + "-flexbox")
                     }
                     if (!q.length) {
                         k = false;
                         return
                     }
                     if (!q.parent(".flexibee-error-box").length) {
                         if (q.hasClass("flexibee-ro-input")) {
                             q.addClass("flexibee-ro-input-keep");
                             q.css("display", "block")
                         }
                         var s = q.is(":focus");
                         q.wrap('<div class="flexibee-error-box">');
                         q.parent(".flexibee-error-box").append('<ul class="flexibee-errors"></ul>');
                         if (s) {
                             q.focus()
                         }
                     }
                     q.parent(".flexibee-error-box").children(".flexibee-errors").append("<li></li>").findLast("li").text(t);
                     q.parent(".flexibee-error-box").addClass("has-error")
                 } else {
                     k = false
                 }
             });
             if (!h && !e && k) {
                 b(".flexibee-error-head", n).remove()
             }
             b.each(l.items, function(r, q) {
                 q.amendFormBad()
             })
         }
         if (p && j.results.length > 0 && j.results[0].content) {
             var i = j.results[0].content[l.evidenceName];
             l.converter.convertJson2Form(i, l.mainForm, l.errorFields);
             l.accessibility.update(i);
             b.each(l.items, function(r, q) {
                 q.amendForm(i[r])
             });
             if (l.onAfterAmend) {
                 l.onAfterAmend(i)
             }
         }
     };
     a.flexibee = a.flexibee || {};
     a.flexibee.FormHelper = c
 })(jQuery, window);