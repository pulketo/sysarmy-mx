<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>CSS CRT screen effect</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
      body {
  background: #111;
  color: white;
  padding-top: 20px;
  padding-left: 20px;
}

#switch {
  display: none;
}

.switch-label {
  display: inline-block;
  cursor: pointer;
  background: #fff;
  color: #111;
  /*padding: 10px;*/
  padding-left: 15px;
  padding-right: 15px;
  border-radius: 5px;
  /*margin-top: 10px;*/
  box-shadow: 0 2px #666;
}
.switch-label::after {
  content: "on";
}
.switch-label::before {
  content: " ";
  display: inline-block;
  border-radius: 100%;
  width: 10px;
  height: 10px;
  background: #003321;
  margin-right: 10px;
  border: 1px solid #111;
}
.switch-label:active {
  box-shadow: none;
  transform: translate3d(0, 2px, 0);
}

#switch:checked + .switch-label::before {
  background: #22ff55;
}
#switch:checked + .switch-label::after {
  content: "off";
}

@keyframes flicker {
  0% {
    opacity: 0.06106;
  }
  5% {
    opacity: 0.42571;
  }
  10% {
    opacity: 0.19847;
  }
  15% {
    opacity: 0.45833;
  }
  20% {
    opacity: 0.92976;
  }
  25% {
    opacity: 0.82436;
  }
  30% {
    opacity: 0.66141;
  }
  35% {
    opacity: 0.28178;
  }
  40% {
    opacity: 0.53025;
  }
  45% {
    opacity: 0.16;
  }
  50% {
    opacity: 0.46595;
  }
  55% {
    opacity: 0.75234;
  }
  60% {
    opacity: 0.69427;
  }
  65% {
    opacity: 0.01759;
  }
  70% {
    opacity: 0.24833;
  }
  75% {
    opacity: 0.75878;
  }
  80% {
    opacity: 0.00555;
  }
  85% {
    opacity: 0.87957;
  }
  90% {
    opacity: 0.14834;
  }
  95% {
    opacity: 0.84373;
  }
  100% {
    opacity: 0.41315;
  }
}
.container {
  background: #121010;
  width: 95%;
  height: 95%;
  margin-top: 10px;
  position: absolute;
  overflow: hidden;
  border: 2px solid #666;
}
.container::after {
  content: " ";
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: rgba(18, 16, 16, 0.1);
  opacity: 0;
  z-index: 2;
  pointer-events: none;
}
.container::before {
  content: " ";
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
  z-index: 2;
  background-size: 100% 2px, 3px 100%;
  pointer-events: none;
}

#switch:checked ~ .container::after {
  animation: flicker 0.15s infinite;
}

@keyframes turn-on {
  0% {
    transform: scale(1, 0.8) translate3d(0, 0, 0);
    -webkit-filter: brightness(30);
    filter: brightness(30);
    opacity: 1;
  }
  3.5% {
    transform: scale(1, 0.8) translate3d(0, 100%, 0);
  }
  3.6% {
    transform: scale(1, 0.8) translate3d(0, -100%, 0);
    opacity: 1;
  }
  9% {
    transform: scale(1.3, 0.6) translate3d(0, 100%, 0);
    -webkit-filter: brightness(30);
    filter: brightness(30);
    opacity: 0;
  }
  11% {
    transform: scale(1, 1) translate3d(0, 0, 0);
    -webkit-filter: contrast(0) brightness(0);
    filter: contrast(0) brightness(0);
    opacity: 0;
  }
  100% {
    transform: scale(1, 1) translate3d(0, 0, 0);
    -webkit-filter: contrast(1) brightness(1.2) saturate(1.3);
    filter: contrast(1) brightness(1.2) saturate(1.3);
    opacity: 1;
  }
}
@keyframes turn-off {
  0% {
    transform: scale(1, 1.3) translate3d(0, 0, 0);
    -webkit-filter: brightness(1);
    filter: brightness(1);
    opacity: 1;
  }
  60% {
    transform: scale(1.3, 0.001) translate3d(0, 0, 0);
    -webkit-filter: brightness(10);
    filter: brightness(10);
  }
  100% {
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    transform: scale(0, 0.0001) translate3d(0, 0, 0);
    -webkit-filter: brightness(50);
    filter: brightness(50);
  }
}
.screen {
  width: 100%;
  height: 100%;
  border: none;
}

#switch ~ .container > .screen {
  animation: turn-off 0.55s cubic-bezier(0.23, 1, 0.32, 1);
  animation-fill-mode: forwards;
}

#switch:checked ~ .container > .screen {
  animation: turn-on 4s linear;
  animation-fill-mode: forwards;
}

@keyframes overlay-anim {
  0% {
    visibility: hidden;
  }
  20% {
    visibility: hidden;
  }
  21% {
    visibility: visible;
  }
  100% {
    visibility: hidden;
  }
}
.overlay {
  color: #00FF00;
  position: absolute;
  top: 20px;
  right: 20px;
  font-size: 60px;
  visibility: hidden;
  pointer-events: none;
}

#switch:checked ~ .container .overlay {
  animation: overlay-anim 5s linear;
  animation-fill-mode: forwards;
}

    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body>
<input type="checkbox" id="switch" checked>
<label for="switch" class="switch-label"></label>
<div class="container">
  <iframe style="width:100%;border:0px;" src="../index.php" class="screen"></iframe>
  <div class="overlay" style="float:right;">AV-1</div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  
</body>
</html>
