
    document.addEventListener("DOMContentLoaded", function () {
      var div,
        n,
        v = document.getElementsByClassName("youtube-player");
      for (n = 0; n < v.length; n++) {
        div = document.createElement("div");
        div.setAttribute("data-id", v[n].dataset.id);
        div.innerHTML = noThumb(v[n].dataset.id);
        div.onclick = noIframe;
        v[n].appendChild(div);
      }
    });

    function noThumb(id) {
      var thumb = '<img src="https://i.ytimg.com/vi/ID/maxresdefault.jpg" style="border-radius:40px">',
        play = '<div class="play"></div>';
      return thumb.replace("ID", id) + play;
    }

    function noIframe() {
      var iframe = document.createElement("iframe");
      var embed =
        "https://www.youtube-nocookie.com/embed/ID?autoplay=1&modestbranding=1&iv_load_policy=3&rel=0&showinfo=0";
      iframe.setAttribute("src", embed.replace("ID", this.dataset.id));
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "1");
      iframe.setAttribute("allow", "autoplay; encrypted-media");
      this.parentNode.replaceChild(iframe, this);
    }

