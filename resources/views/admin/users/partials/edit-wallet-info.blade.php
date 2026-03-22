<style>
    .skeleton {
        animation: skeleton-loading 1.5s infinite linear;
        background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
        background-size: 1000px 104px;
        height: 20px;
        width: 100%;
    }

    @keyframes skeleton-loading {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }
</style>

<div class="card">
    <div class="card-header justify-content-center">
        <h2 class="mb-0">{{ __('Thông tin ví Wallet') }}</h2>

    </div>
    <div class="row card-body">
       <div class="row d-flex align-items-center">
           {{-- amount --}}
           <div class="col-md-6 col-sm-12">
               <div class="card mb-3">
                   <div class="card-body">
                       <label for="balance" class="form-label">{{ __('balance') }}:</label>
                       <p id="balance" class="fs-4 fw-bold text-primary skeleton"></p>
                   </div>
               </div>
           </div>


           <!-- Nút Nạp tiền và Rút tiền -->
           <div class="col-md-6 col-sm-12">
               <div class="mb-3">
                   <button type="button" class="btn btn-primary"
                           data-bs-toggle="modal"
                           data-bs-target="#depositModal">
                       <i class="fas fa-plus"></i> {{ __('Nạp tiền') }}
                   </button>
                   <button type="button" class="btn btn-warning"
                           data-bs-toggle="modal"
                           data-bs-target="#withdrawModal">
                       <i class="fas fa-minus"></i> {{ __('Rút tiền') }}
                   </button>
               </div>
           </div>
       </div>

        <!-- Modal Nạp tiền -->
        @include('admin.users.partials.modal.modal-deposit')
        @include('admin.users.partials.modal.modal-withdraw')

    </div>
</div>
