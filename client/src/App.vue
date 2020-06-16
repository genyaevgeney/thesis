<template>
  <router-view />
</template>

<script>
  export default {
    name: 'App',
  }
</script>

<style lang="scss">
  @font-face {
    font-family: 'BebasNeue-Bold';
    src: url('~@/assets/fonts/BebasNeue/BebasNeue-Bold.otf')  format('opentype'); /* Safari, Android, iOS */
  }

  @font-face {
    font-family: 'BebasNeue-Book';
    src: url('~@/assets/fonts/BebasNeue/BebasNeue-Book.otf')  format('opentype'); /* Safari, Android, iOS */
  }

  @font-face {
    font-family: 'BebasNeue-Light';
    src: url('~@/assets/fonts/BebasNeue/BebasNeue-Light.otf')  format('opentype'); /* Safari, Android, iOS */
  }

  @font-face {
    font-family: 'BebasNeue-Regular';
    src: url('~@/assets/fonts/BebasNeue/BebasNeue-Regular.otf')  format('opentype'); /* Safari, Android, iOS */
  }

  @font-face {
    font-family: 'BebasNeue-Thin';
    src: url('~@/assets/fonts/BebasNeue/BebasNeue-Thin.otf')  format('opentype'); /* Safari, Android, iOS */
  }

  a {
    &:hover {
      text-decoration: none;
    }
  }

  .hover-scale-shadow {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);

    &::after {
      content: "";
      border-radius: 5px;
      position: absolute;
      z-index: -1;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      opacity: 0;
      -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
      transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    &:hover {
      -webkit-transform: scale(1.15, 1.25);
      transform: scale(1.15, 1.25);

      &::after {
          opacity: 1;
      }
    }
  }

.lds-ring {
  display: none;
  position: relative;
  width: 25px;
  height: 25px;
  margin-right: 8px;
}
.lds-ring div {
  $size: 20px;
  box-sizing: border-box;
  display: block;
  position: absolute;
  top:calc(50% - ($size/2));
  right:calc(50% - ($size/2));
  width: $size;
  height: $size;
  margin: 3px;
  border: 3px solid #fff;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #fff transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.show-load {
  display: inline-block;
}

.block-event {
  pointer-events: none;
  opacity: .7;
}

.vue-tab {
  color:black;
  font-size: 15px;
  font-family: "Sylfaen", sans-serif;
  padding: 8px 22px !important;

  &:not(:last-child) {
    margin-right: 8px;
  }

  &[aria-selected="true"] {
    color:white;
    background-color: #4CAF50;
  }
}

.vue-tablist {
  margin-bottom: 0;
}

::-webkit-scrollbar-track {
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
}

::-webkit-scrollbar {
	width: 18px;
  height:18px;
}

::-webkit-scrollbar-thumb {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}

.vm--modal {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items:center;

        .modal-btn {
          display: block;
          background-color: #2F2F30;
          color:white;
          font-family: "Sylfaen", sans-serif;
          font-size:19px;
          width: 53%;
          text-decoration:none;
          padding: 10px 0;
          border-radius: 4px;
          text-align:center;
          transition:opacity .3s ease;

          &:not(:last-child) {
            margin-bottom: 20px;
          }

          &:hover {
            opacity:.7;
          }
        }
      }
</style>
