!(function (a) {
    "use strict";

    function e() {}
    (e.prototype.init = function () {
        a(".select2").select2(),
            a(".select2-limiting").select2({
                maximumSelectionLength: 2,
            }),
            a(".select2-search-disable").select2({
                minimumResultsForSearch: 1 / 0,
            }),
            a(".select2-ajax").select2({
                ajax: {
                    url: "https://api.github.com/search/repositories",
                    dataType: "json",
                    delay: 250,
                    data: function (e) {
                        return {
                            q: e.term,
                            page: e.page,
                        };
                    },
                    processResults: function (e, t) {
                        return (
                            (t.page = t.page || 1),
                            {
                                results: e.items,
                                pagination: {
                                    more: 30 * t.page < e.total_count,
                                },
                            }
                        );
                    },
                    cache: !0,
                },
                placeholder: "Search for a repository",
                minimumInputLength: 1,
                templateResult: function (e) {
                    if (e.loading) return e.text;
                    var t = a(
                        "<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='" +
                            e.owner.avatar_url +
                            "' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'></div><div class='select2-result-repository__description'></div><div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div></div></div></div>"
                    );
                    return (
                        t
                            .find(".select2-result-repository__title")
                            .text(e.full_name),
                        t
                            .find(".select2-result-repository__description")
                            .text(e.description),
                        t
                            .find(".select2-result-repository__forks")
                            .append(e.forks_count + " Forks"),
                        t
                            .find(".select2-result-repository__stargazers")
                            .append(e.stargazers_count + " Stars"),
                        t
                            .find(".select2-result-repository__watchers")
                            .append(e.watchers_count + " Watchers"),
                        t
                    );
                },
                templateSelection: function (e) {
                    return e.full_name || e.text;
                },
            }),
            a(".select2-templating").select2({
                templateResult: function (e) {
                    return e.id
                        ? a(
                              '<span><img src="/assets/images/flags/select2/' +
                                  e.element.value.toLowerCase() +
                                  '.png" class="img-flag" /> ' +
                                  e.text +
                                  "</span>"
                          )
                        : e.text;
                },
            });
    }),
        (a.AdvancedForm = new e()),
        (a.AdvancedForm.Constructor = e);
})(window.jQuery),
    (function () {
        "use strict";
        window.jQuery.AdvancedForm.init();
    })(),
    $(function () {
        "use strict";
        var o = $(".docs-date"),
            c = $(".docs-datepicker-container"),
            r = $(".docs-datepicker-trigger"),
            l = {
                show: function (e) {
                    console.log(e.type, e.namespace);
                },
                hide: function (e) {
                    console.log(e.type, e.namespace);
                },
                pick: function (e) {
                    console.log(e.type, e.namespace, e.view);
                },
            };
        o
            .on({
                "show.datepicker": function (e) {
                    console.log(e.type, e.namespace);
                },
                "hide.datepicker": function (e) {
                    console.log(e.type, e.namespace);
                },
                "pick.datepicker": function (e) {
                    console.log(e.type, e.namespace, e.view);
                },
            })
            .datepicker(l),
            $(".docs-options, .docs-toggles").on("change", function (e) {
                var t,
                    a = e.target,
                    s = $(a),
                    n = s.attr("name"),
                    i = "checkbox" === a.type ? a.checked : s.val();
                switch (n) {
                    case "container":
                        i ? (i = c).show() : c.hide();
                        break;
                    case "trigger":
                        i
                            ? (i = r).prop("disabled", !1)
                            : r.prop("disabled", !0);
                        break;
                    case "inline":
                        (t = $('input[name="container"]')).prop("checked") ||
                            t.click();
                        break;
                    case "language":
                        $('input[name="format"]').val(
                            $.fn.datepicker.languages[i].format
                        );
                }
                (l[n] = i),
                    o.datepicker("reset").datepicker("destroy").datepicker(l);
            }),
            $(".docs-actions").on("click", "button", function (e) {
                var t,
                    a = $(this).data(),
                    s = a.arguments || [];
                e.stopPropagation(),
                    a.method &&
                        (a.source
                            ? o.datepicker(a.method, $(a.source).val())
                            : (t = o.datepicker(a.method, s[0], s[1], s[2])) &&
                              a.target &&
                              $(a.target).val(t));
            });
    });
