const videoModel = document.getElementById("videoModel");
const halfVideoModel = document.getElementById("halfVideoModel");
const iframe = document.querySelector("#videoModel iframe");
const video = document.querySelector("#videoModel video");
const halfIframe = document.querySelector("#halfVideoModel iframe");
const halfVideo = document.querySelector("#halfVideoModel video");

if (iframe) {
  const src = iframe.getAttribute("src");
  if (videoModel) {
    videoModel.addEventListener("hidden.bs.modal", (event) => {
      if (iframe) {
        iframe.removeAttribute("src");
      }
    });

    videoModel.addEventListener("show.bs.modal", (event) => {
      if (iframe) {
        iframe.setAttribute("src", src);
      }
    });
  }
}
if (halfIframe) {
  const hsrc = halfIframe.getAttribute("src");

  if (halfVideoModel) {
    halfVideoModel.addEventListener("hidden.bs.modal", (event) => {
      if (halfIframe) {
        halfIframe.removeAttribute("src");
      }
    });

    halfVideoModel.addEventListener("show.bs.modal", (event) => {
      if (halfIframe) {
        halfIframe.setAttribute("src", hsrc);
      }
    });
  }
}

if (video) {
  if (videoModel) {
    videoModel.addEventListener("hidden.bs.modal", (event) => {
      video.pause();
    });

    videoModel.addEventListener("show.bs.modal", (event) => {
      video.play();
    });
  }
}

if (halfVideo) {
  if (halfVideoModel) {
    halfVideoModel.addEventListener("hidden.bs.modal", (event) => {
      halfVideo.pause();
    });

    halfVideoModel.addEventListener("show.bs.modal", (event) => {
      halfVideo.play();
    });
  }
}
