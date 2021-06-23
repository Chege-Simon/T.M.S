<template>
  <div class="modal fade" id="create-model">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal <slot name="header"></slot> </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    },
    maxWidth: {
      default: 'md'
    }
  },

  computed: {
    maxWidthClass() {
      return {
        'sm': 'modal-sm',
        'md': null,
        'lg': 'modal-lg',
        'xl': 'modal-xl',
      }[this.maxWidth]
    }
  }
}
</script>
