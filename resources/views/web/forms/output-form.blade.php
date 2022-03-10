<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Login - Form Gen App" />
        <meta name="author" content="" />
        <title>Form Gen App - {{ $resultData->name ? $resultData->name : 'N/A' }}</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="layoutError">
            <div id="layoutError_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="mt-4">
                                    <h1 class="display-1">{{ $resultData->name ? $resultData->name : 'N/A' }}</h1>
                                    <p>Created on {{ $resultData->created_at ? date('d-M-Y H:i A',strtotime($resultData->created_at)) : '' }}</p>
                                    @if($resultFormFields)
                                        <form id="">
                                            @foreach ($resultFormFields as $formFields)
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <label>{{ $formFields->field_name ? $formFields->field_name : 'N/A' }}</label>
                                                        @if($formFields->field_type==1)
                                                            <input class="form-control" name="{{ $formFields->field_name ? $formFields->field_name : 'N/A' }}" type="text">
                                                        @elseif ($formFields->field_type==2)
                                                            <textarea class="form-control" name="{{ $formFields->field_name ? $formFields->field_name : 'N/A' }}"></textarea>
                                                        @elseif ($formFields->field_type==3)
                                                            <select class="form-control form-select" name="{{ $formFields->field_name ? $formFields->field_name : 'N/A' }}">
                                                                <option value="">Select one</option>
                                                                @if($formFields->field_values)
                                                                    @php
                                                                        $fieldValues = explode(",",$formFields->field_values);
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $fieldValues = array();
                                                                    @endphp
                                                                @endif
                                                                @if($fieldValues)
                                                                    @foreach ($fieldValues as $options)
                                                                        <option value="{{ $options }}">{{ $options }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        @elseif ($formFields->field_type==4)
                                                            <input class="form-control" name="{{ $formFields->field_name ? $formFields->field_name : 'N/A' }}" type="number">
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="mt-2">
                                                <button class="btn btn-success" type="submit">Save</button>
                                            </div>
                                        </form>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutError_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; {{ date('Y') }}</div>
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
