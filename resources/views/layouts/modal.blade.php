<!-- Modal -->
<div class="modal fade" id="notification" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul>
          @foreach ($notifications as $notification)
              <li>{{ $notification->data['msg'] }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>