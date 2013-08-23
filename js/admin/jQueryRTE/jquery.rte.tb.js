var rte_tag = "-rte-tmp-tag-";
var rte_toolbar = {
    s1: {
        separator: true
    },
    bold: {
        command: "bold",
        tags: ["b", "strong"]
    },
    italic: {
        command: "italic",
        tags: ["i", "em"]
    },
    //strikeThrough: {
    //    command: "strikethrough",
    //    tags: ["s", "strike"]
    //},
    //underline: {
    //    command: "underline",
    //    tags: ["u"]
    //},
    s2: {
        separator: true
    },
    //justifyLeft: {
    //    command: "justifyleft"
    //},
    //justifyCenter: {
    //    command: "justifycenter"
    //},
    //justifyRight: {
    //    command: "justifyright"
    //},
    //justifyFull: {
    //    command: "justifyfull"
    //},
    //s3: {
    //    separator: true
    //},
    //s4: {
    //    separator: true
    //},
    //subscript: {
    //    command: "subscript",
    //    tags: ["sub"]
    //},
    //superscript: {
    //    command: "superscript",
    //    tags: ["sup"]
    //},
    //s5: {
    //    separator: true
    //},
    orderedList: {
        command: "insertorderedlist",
        tags: ["ol"]
    },
    unorderedList: {
        command: "insertunorderedlist",
        tags: ["ul"]
    },
    indent: {
        command: "indent"
    },
    outdent: {
        command: "outdent"
    },

    s3: {
        separator: true
    },

    h1: {
        command: "formatblock",
        tags: ["h1"],
        args: ["h1"]
    },

    h2: {
        command: "formatblock",
        tags: ["h2"],
        args: ["h2"]
    },

    h3: {
        command: "formatblock",
        tags: ["h3"],
        args: ["h3"]
    },

    // ��� �� ����� ���� ������� ��������
    justifyFull: {
        command: "formatblock",
        tags: ["p"],
        args: ["p"]
    },

    //s6: {
    //    separator: true
    //},
    //
    //block: {
    //    command: "formatblock",
    //    select: '<select>\
    //        <option value="">- ����� -</option>\
    //        <option value="<p>">�������</option>\
    //        <option value="<h1>">��������� 1</option>\
    //        <option value="<h2>">��������� 2</options>\
    //        <option value="<h3>">��������� 3</option>\
    //        <option value="<h4>">��������� 4</options>\
    //        <option value="<h5>">��������� 5</option>\
    //        <option value="<h6>">��������� 6</options>\
    //    </select>',
    //    tag_cmp: lwrte_block_compare,
    //    tags: ["p", "h1", "h2", "h3", "h4", "h5", "h6"]
    //},



//    image: {
//        exec: lwrte_image,
//        tags: ["img"]
//    },
    //link: {
    //    exec: lwrte_link,
    //    tags: ["a"]
    //},
    //unlink: {
    //    command: "unlink"
    //},
    s8: {
        separator: true
    },
    removeFormat: {
        exec: lwrte_unformat
    }
//    ,
//    word: {
//        exec: lwrte_cleanup_word
//    },
//    clear: {
//        exec: lwrte_clear
//    }
};
var html_toolbar = {
    s1: {
        separator: true
    },

//    word: {
//        exec: lwrte_cleanup_word
//    },

//    removeFormat: {
//        exec: lwrte_unformat
//    },


    clear: {
        exec: lwrte_clear
    }
};
function lwrte_block_compare(b, a) {
    a = a.replace(/<([^>]*)>/, "$1");
    return (a.toLowerCase() == b.nodeName.toLowerCase())
}
function lwrte_style_init(b) {
    var a = this;
    a.select = '<select><option value="">- no css -</option></select>';
    if (b.css.length) {
        jQuery.ajax({
            url: "styles.php",
            type: "POST",
            data: {
                css: b.css[b.css.length - 1]
            },
            async: false,
            success: function(f) {
                var e = f.split(",");
                var c = "";
                for (var d in e) {
                    c += '<option value="' + e[d] + '">' + e[d] + "</option>"
                }
                a.select = '<select><option value="">- css -</option>' + c + "</select>"
            }
        })
    }
}
function lwrte_style(b) {
    if (b) {
        try {
            var d = b.options[b.selectedIndex].value;
            var a = this;
            var c = a.get_selected_text();
            c = '<span class="' + d + '">' + c + "</span>";
            a.selection_replace_with(c);
            b.selectedIndex = 0
        } catch(f) {}
    }
}
function lwrte_color() {
    var p = this;
    var a = p.create_panel("Set color for text", 385);
    var n = false;
    var j = false;
    a.append('<div class="colorpicker1"><div class="rgb" id="rgb"></div></div><div class="colorpicker1"><div class="gray" id="gray"></div></div><div class="colorpicker2">	<div class="palette" id="palette"></div>	<div class="preview" id="preview"></div>	<div class="color" id="color"></div></div><div class="clear"></div><p class="submit"><button id="ok">Ok</button><button id="cancel">Cancel</button></p>').show();
    var l = jQuery("#preview", a);
    var f = jQuery("#color", a);
    var d = jQuery("#palette", a);
    var b = ["#660000", "#990000", "#cc0000", "#ff0000", "#333333", "#006600", "#009900", "#00cc00", "#00ff00", "#666666", "#000066", "#000099", "#0000cc", "#0000ff", "#999999", "#909000", "#900090", "#009090", "#ffffff", "#cccccc", "#ffff00", "#ff00ff", "#00ffff", "#000000", "#eeeeee"];
    for (var h = 0; h < b.length; h++) {
        jQuery("<div></div>").addClass("item").css("background", b[h]).appendTo(d)
    }
    var o = jQuery("#rgb").height();
    var k = jQuery("#rgb").width() / 6;
    jQuery("#rgb,#gray,#palette", a).mousedown(function(i) {
        n = true;
        return false
    }).mouseup(function(i) {
        n = false;
        return false
    }).mouseout(function(i) {
        j = false;
        return false
    }).mouseover(function(i) {
        j = true;
        return false
    });
    jQuery("#rgb").mousemove(function(i) {
        if (n && j) {
            m(this, true, false, false, i)
        }
        return false
    });
    jQuery("#gray").mousemove(function(i) {
        if (n && j) {
            m(this, false, true, false, i)
        }
        return false
    });
    jQuery("#palette").mousemove(function(i) {
        if (n && j) {
            m(this, false, false, true, i)
        }
        return false
    });
    jQuery("#rgb").click(function(i) {
        m(this, true, false, false, i);
        return false
    });
    jQuery("#gray").click(function(i) {
        m(this, false, true, false, i);
        return false
    });
    jQuery("#palette").click(function(i) {
        m(this, false, false, true, i);
        return false
    });
    jQuery("#cancel", a).click(function() {
        a.remove();
        return false
    });
    jQuery("#ok", a).click(function() {
        var i = f.html();
        if (i.length > 0 && i.charAt(0) == "#") {
            if (p.iframe_doc.selection) {
                p.range.select()
            }
            p.editor_cmd("foreColor", i)
        }
        a.remove();
        return false
    });
    function g(q) {
        var i = "0123456789abcdef";
        return i.charAt(Math.floor(q / 16)) + i.charAt(q % 16)
    }
    function e(q) {
        var s = {
            x: q.offsetLeft,
            y: q.offsetTop
        };
        if (q.offsetParent) {
            var i = e(q.offsetParent);
            s.x += i.x;
            s.y += i.y
        }
        return s
    }
    function c(s, r) {
        var i, u;
        r = r || window.event;
        var q = r.target || r.srcElement;
        var t = e(s);
        i = r.pageX - t.x;
        u = r.pageY - t.y;
        return {
            x: i,
            y: u
        }
    }
    function m(u, q, E, s, z) {
        var i, v, C, A;
        var w = c(u, z);
        var D = w.x;
        var B = w.y;
        if (q) {
            i = (D >= 0) * (D < k) * 255 + (D >= k) * (D < 2 * k) * (2 * 255 - D * 255 / k) + (D >= 4 * k) * (D < 5 * k) * ( - 4 * 255 + D * 255 / k) + (D >= 5 * k) * (D < 6 * k) * 255;
            v = (D >= 0) * (D < k) * (D * 255 / k) + (D >= k) * (D < 3 * k) * 255 + (D >= 3 * k) * (D < 4 * k) * (4 * 255 - D * 255 / k);
            C = (D >= 2 * k) * (D < 3 * k) * ( - 2 * 255 + D * 255 / k) + (D >= 3 * k) * (D < 5 * k) * 255 + (D >= 5 * k) * (D < 6 * k) * (6 * 255 - D * 255 / k);
            var t = (o - B) / o;
            i = 128 + (i - 128) * t;
            v = 128 + (v - 128) * t;
            C = 128 + (C - 128) * t
        } else {
            if (E) {
                i = v = C = (o - B) * 1.7
            } else {
                if (s) {
                    D = Math.floor(D / 10);
                    B = Math.floor(B / 10);
                    A = b[D + B * 5]
                }
            }
        }
        if (!s) {
            A = "#" + g(i) + g(v) + g(C)
        }
        l.css("background", A);
        f.html(A)
    }
}
function lwrte_image() {
    var self = this;
    var panel = self.create_panel("Insert image", 385);
    panel.append('<p><label>URL</label><input type="text" id="url" size="30" value=""><button id="file">Upload</button><button id="view">View</button></p><div class="clear"></div><p class="submit"><button id="ok">Ok</button><button id="cancel">Cancel</button></p>').show();
    var url = jQuery("#url", panel);
    var upload = jQuery("#file", panel).upload({
        autoSubmit: false,
        action: "uploader.php",
        onSelect: function() {
            var file = this.filename();
            var ext = (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : "";
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                alert("Invalid file extension");
                return
            }
            this.submit()
        },
        onComplete: function(response) {
            if (response.length <= 0) {
                return
            }
            response = eval("(" + response + ")");
            if (response.error && response.error.length > 0) {
                alert(response.error)
            } else {
                url.val((response.file && response.file.length > 0) ? response.file: "")
            }
        }
    });
    jQuery("#view", panel).click(function() { (url.val().length > 0) ? window.open(url.val()) : alert("Enter URL of image to view");
        return false
    });
    jQuery("#cancel", panel).click(function() {
        panel.remove();
        return false
    });
    jQuery("#ok", panel).click(function() {
        var file = url.val();
        self.editor_cmd("insertImage", file);
        panel.remove();
        return false
    })
}







function lwrte_unformat() {
//    this.editor_cmd("removeFormat");
//    this.editor_cmd("unlink")
    ClearFormatBody(jQuery("body", this.iframe_doc)[0]);
}
function lwrte_clear() {
    if (confirm("Clear Document?")) {
        this.set_content("")
    }
}
function lwrte_cleanup_word() {
    this.set_content(a(this.get_content(), true, true, true));
    function a(d, b, e, f) {
        d = d.replace(/<o:p>\s*<\/o:p>/g, "");
        d = d.replace(/<o:p>[\s\S]*?<\/o:p>/g, "&nbsp;");
        d = d.replace(/\s*mso-[^:]+:[^;"]+;?/gi, "");
        d = d.replace(/\s*MARGIN: 0cm 0cm 0pt\s*;/gi, "");
        d = d.replace(/\s*MARGIN: 0cm 0cm 0pt\s*"/gi, '"');
        d = d.replace(/\s*TEXT-INDENT: 0cm\s*;/gi, "");
        d = d.replace(/\s*TEXT-INDENT: 0cm\s*"/gi, '"');
        d = d.replace(/\s*TEXT-ALIGN: [^\s;]+;?"/gi, '"');
        d = d.replace(/\s*PAGE-BREAK-BEFORE: [^\s;]+;?"/gi, '"');
        d = d.replace(/\s*FONT-VARIANT: [^\s;]+;?"/gi, '"');
        d = d.replace(/\s*tab-stops:[^;"]*;?/gi, "");
        d = d.replace(/\s*tab-stops:[^"]*/gi, "");
        if (b) {
            d = d.replace(/\s*face="[^"]*"/gi, "");
            d = d.replace(/\s*face=[^ >]*/gi, "");
            d = d.replace(/\s*FONT-FAMILY:[^;"]*;?/gi, "")
        }
        d = d.replace(/<(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "<$1$3");
        if (e) {
            d = d.replace(/<(\w[^>]*) style="([^\"]*)"([^>]*)/gi, "<$1$3")
        }
        d = d.replace(/<STYLE[^>]*>[\s\S]*?<\/STYLE[^>]*>/gi, "");
        d = d.replace(/<(?:META|LINK)[^>]*>\s*/gi, "");
        d = d.replace(/\s*style="\s*"/gi, "");
        d = d.replace(/<SPAN\s*[^>]*>\s*&nbsp;\s*<\/SPAN>/gi, "&nbsp;");
        d = d.replace(/<SPAN\s*[^>]*><\/SPAN>/gi, "");
        d = d.replace(/<(\w[^>]*) lang=([^ |>]*)([^>]*)/gi, "<$1$3");
        d = d.replace(/<SPAN\s*>([\s\S]*?)<\/SPAN>/gi, "$1");
        d = d.replace(/<FONT\s*>([\s\S]*?)<\/FONT>/gi, "$1");
        d = d.replace(/<\\?\?xml[^>]*>/gi, "");
        d = d.replace(/<w:[^>]*>[\s\S]*?<\/w:[^>]*>/gi, "");
        d = d.replace(/<\/?\w+:[^>]*>/gi, "");
        d = d.replace(/<\!--[\s\S]*?-->/g, "");
        d = d.replace(/<(U|I|STRIKE)>&nbsp;<\/\1>/g, "&nbsp;");
        d = d.replace(/<H\d>\s*<\/H\d>/gi, "");
        d = d.replace(/<(\w+)[^>]*\sstyle="[^"]*DISPLAY\s?:\s?none[\s\S]*?<\/\1>/ig, "");
        d = d.replace(/<(\w[^>]*) language=([^ |>]*)([^>]*)/gi, "<$1$3");
        d = d.replace(/<(\w[^>]*) onmouseover="([^\"]*)"([^>]*)/gi, "<$1$3");
        d = d.replace(/<(\w[^>]*) onmouseout="([^\"]*)"([^>]*)/gi, "<$1$3");
        if (f) {
            d = d.replace(/<H(\d)([^>]*)>/gi, "<h$1>");
            d = d.replace(/<(H\d)><FONT[^>]*>([\s\S]*?)<\/FONT><\/\1>/gi, "<$1>$2</$1>");
            d = d.replace(/<(H\d)><EM>([\s\S]*?)<\/EM><\/\1>/gi, "<$1>$2</$1>")
        } else {
            d = d.replace(/<H1([^>]*)>/gi, '<div$1><b><font size="6">');
            d = d.replace(/<H2([^>]*)>/gi, '<div$1><b><font size="5">');
            d = d.replace(/<H3([^>]*)>/gi, '<div$1><b><font size="4">');
            d = d.replace(/<H4([^>]*)>/gi, '<div$1><b><font size="3">');
            d = d.replace(/<H5([^>]*)>/gi, '<div$1><b><font size="2">');
            d = d.replace(/<H6([^>]*)>/gi, '<div$1><b><font size="1">');
            d = d.replace(/<\/H\d>/gi, "</font></b></div>");
            var c = new RegExp("(<P)([^>]*>[\\s\\S]*?)(</P>)", "gi");
            d = d.replace(c, "<div$2</div>");
            d = d.replace(/<([^\s>]+)(\s[^>]*)?>\s*<\/\1>/g, "");
            d = d.replace(/<([^\s>]+)(\s[^>]*)?>\s*<\/\1>/g, "");
            d = d.replace(/<([^\s>]+)(\s[^>]*)?>\s*<\/\1>/g, "")
        }
        return d
    }
}
function lwrte_link() {
    var self = this;
    var panel = self.create_panel("Create link / Attach file", 385);
    panel.append('<p><label>URL</label><input type="text" id="url" size="30" value=""><button id="file">Attach File</button><button id="view">View</button></p><div class="clear"></div><p><label>Title</label><input type="text" id="title" size="30" value=""><label>Target</label><select id="target"><option value="">default</option><option value="_blank">new</option></select></p><div class="clear"></div><p class="submit"><button id="ok">Ok</button><button id="cancel">Cancel</button></p>').show();
    jQuery("#cancel", panel).click(function() {
        panel.remove();
        return false
    });
    var url = jQuery("#url", panel);
    var upload = jQuery("#file", panel).upload({
        autoSubmit: true,
        action: "uploader.php",
        onComplete: function(response) {
            if (response.length <= 0) {
                return
            }
            response = eval("(" + response + ")");
            if (response.error && response.error.length > 0) {
                alert(response.error)
            } else {
                url.val((response.file && response.file.length > 0) ? response.file: "")
            }
        }
    });
    jQuery("#view", panel).click(function() { (url.val().length > 0) ? window.open(url.val()) : alert("Enter URL to view");
        return false
    });
    jQuery("#ok", panel).click(function() {
        var url = jQuery("#url", panel).val();
        var target = jQuery("#target", panel).val();
        var title = jQuery("#title", panel).val();
        if (self.get_selected_text().length <= 0) {
            alert("�������� �����, ������� ����� �������!");
            return false
        }
        panel.remove();
        if (url.length <= 0) {
            return false
        }
        self.editor_cmd("unlink");
        self.editor_cmd("createLink", rte_tag);
        var tmp = jQuery("<span></span>").append(self.get_selected_html());
        if (target.length > 0) {
            jQuery('a[href*="' + rte_tag + '"]', tmp).attr("target", target)
        }
        if (title.length > 0) {
            jQuery('a[href*="' + rte_tag + '"]', tmp).attr("title", title)
        }
        jQuery('a[href*="' + rte_tag + '"]', tmp).attr("href", url);
        self.selection_replace_with(tmp.html());
        return false
    })
};

function ClearFormatBody(body1) {
    this.mswordclean = function(o) {
        
        // ������� ����
        //"b","i",
        var goodTags0 = ["a", "p", "br", "ul", "ol", "li", "img", "table", "tbody", "thead", "tfoot", "caption", "tr", "td", "th", "col", "colgroup", "sub", "sup"];

        // ����, ������� canHaveHTML() � ����� ���� �������.
        var canEmptyTags0 = ["td", "th"];

        var goodAttributes0 = [];

        // ������� �������� (��������� � ���� �����)
        goodAttributes0[""] = ["href", "name", "title", "alt", "src", "id"];

        // �������������� ���������� �������� ��� ��������� �����
        goodAttributes0["img"] = ["width", "height", "align"];
        goodAttributes0["table"] = [];
        goodAttributes0["td"] = ["colSpan", "rowSpan"];
        goodAttributes0["tr td col colgroup"] = ["noWrap", "colSpan", "rowSpan"];
        goodAttributes0["a area"] = ["href", "name"];
        goodAttributes0["br"] = ["clear"];

        // ���������� ��������� ������-�������� (����������� � ��������� attributes)
        mustDieAttributes = ["x:str", "x:num", "x:fmla"]; // �������� - � 6-�� MSIE �������� �������������� ��������� � ���� TABLE ����� � ����� ��������

        // ������� ������ (�� �������)
        var goodClasses0 = [];

        var goodTags = [];
        for (var i in goodTags0) {
            goodTags[goodTags0[i]] = true
        }
        var canEmptyTags = [];
        for (var i in canEmptyTags0) {
            canEmptyTags[canEmptyTags0[i]] = true
        }

        var goodAttributes = [];
        for (var i in goodAttributes0) {
            var splitted = i.split(" ");
            for (var ii in splitted) {
                goodAttributes[splitted[ii]] = [];
                for (j in goodAttributes0[i]) {
                    goodAttributes[splitted[ii]][goodAttributes0[i][j]] = true;
                }
            }
        }
        goodClasses = [];
        for (i in goodClasses0) {
            goodClasses[goodClasses0[i]] = true;
        }
        function cleanObject(o) {
            var s = "";
            var myAttributes = [];
            var i;

            if (!o.attr("tagName")) return;

            //console.log("OK")

            if (o.outerHTML && o.outerHTML.substr(0, 2) == "<?") {
                o.parentNode.removeChild[o];
                return;
            }

            var tag = o.attr("tagName").toLowerCase();

            // ������� ������, �������� � ������ ����
            if (!goodTags[tag] || (self.clean_a && tag == "a") || (self.clean_img && tag == "img") || (o.canHaveHTML && o.innerHTML == "" && !canEmptyTags[tag])) {

                // ��������� ����� � �������

                var addTag = []
                // console.log(o,o.css("font-style"));

                if (parseInt(o.css("font-weight")) > 400) {
                    //addTag.push('b')
                }
                if (o.css("font-style") == 'italic') {
                    //addTag.push('i')
                }

                //console.log('addTag',addTag)
                var before = '';
                var after = '';
                jQuery.each(addTag, function(i, tag) {
                    //console.log("�� ", o.attr("tagName"), " ", o.html());
                    before += '<' + tag + '>';
                    after = '</' + tag + '>' + after;
                    //console.log("����� ",o.html());
                });
                o = o.replaceWith(before + o.html() + after);

                return;
            }

            var a = jQuery.getAttributes(o);
            if (!a) return;

            for (i in a) { // ��...
                //				if(""+a[i]!="null"){ // �������, �� ������ if(a[i]) �� �����������
                //                            console.log(i," ",a[i])
                myAttributes[i] = a[i]
                //				}
            }
            // ������ ������ �������� � ������ ������
            for (i in myAttributes) {
                //console.log("attr name",i);
                //i=i.toLowerCase()
                if ((!goodAttributes[""][i] && (!goodAttributes[tag] || !goodAttributes[tag][i] || i == "class" || i == "className")) || (self.clean_colors && (i == "bgColor" || i == "color")) || (self.clean_aligns && (i == "align" || i == "vAlign"))) {
                    if (i == "class") {
                        // i="className"
                    }
                    if (i != "class" || !goodClasses[o.className]) {
                        //console.log(i)
                        o.removeAttr(i)
                        //console.log('ok')
                    }
                }
            }
            // � 6-�� MSIE �� ������ ���������� ��������� � ������. ��. ����.
            if (o.attr("tagName").toLowerCase() != "table") {
                for (var i=0; i<mustDieAttributes.length;i++) {
                    try {
                        o.removeAttr(mustDieAttributes[i])
                    } catch (e) {
                        //console.log("bad attrib",mustDieAttributes[i])
                    }
                }
            }
            o.css = {};
        }

        function cleanTree(o, mustClean) {
            var c = o.childNodes;
            var i;
            if (c) {
                for (i = c.length - 1; i >= 0; i--) {
                    cleanTree(c[i], true)
                }
            }

            if (mustClean) {
                //console.log("ct",o)
                cleanObject(jQuery(o))
            }
        }
        cleanTree(o, false);
        o = jQuery(o);
        //                console.log("aaaaa",o.html());
        o.html(o.html().replace(/(\s*&nbsp;\s*)+/gi, '&nbsp;'));
        o.html(o.html().replace(/<P>(&nbsp;)?<\/P>/gi, ''));
        o.html(o.html().replace(/<br\/?>/gi, '<p>'));
        //		o.html(o.html.replace(/<P>&nbsp;<\/P>/gi,''));
        //		prompt('����������?',o.innerHTML);

    }
    //        debugger
    this.mswordclean(body1);
}



