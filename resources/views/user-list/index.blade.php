@extends('welcome')

@section('title', 'Список пользователей')

@section('content')
    <style>
        .pagination-info, .small.text-muted { display: none !important; }
    </style>
    <div class="d-flex justify-content-between">
        <h2>Список пользователей</h2>
        <div class="mb-3">
            <button id="export-button" class="btn btn-danger">Выгрузить пользователей</button>
            <button id="download-button" class="btn btn-success" style="display: none;">Скачать</button>
            <span id="export-status" class="ms-3 text-primary"></span>
        </div>
    </div>
    <div class="d-flex justify-content-start mt-4">
        {{ $userList->links('pagination::bootstrap-5') }}
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Телефон</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userList as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Нет пользователей</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-start mt-4">
        {{ $userList->links('pagination::bootstrap-5') }}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let page = 1;
            let filename = null;

            const exportBtn = document.getElementById('export-button');
            const downloadBtn = document.getElementById('download-button');

            if (!exportBtn || !downloadBtn) {
                console.error('Кнопки не найдены в DOM!');
                return;
            }

            function exportChunk() {
                fetch('/user-list/export', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ page, filename })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            resetButtons();
                            return;
                        }

                        filename = data.filename;
                        exportBtn.innerText = `Обработка страницы ${page}...`;

                        if (data.done) {
                            exportBtn.style.display = 'none';
                            downloadBtn.style.display = 'inline-block';
                            downloadBtn.onclick = () => {
                                window.location.href = `/export/download/${filename}`;
                                // после скачивания возвращаем кнопку экспорта
                                downloadBtn.style.display = 'none';
                                exportBtn.innerText = 'Выгрузить пользователей';
                                exportBtn.disabled = false;
                                exportBtn.style.display = 'inline-block';
                            };
                        } else {
                            page = data.nextPage;
                            setTimeout(exportChunk, 100);
                        }
                    })
                    .catch(err => {
                        alert('Ошибка при экспорте');
                        console.error(err);
                        resetButtons();
                    });
            }

            function resetButtons() {
                exportBtn.innerText = 'Выгрузить пользователей';
                exportBtn.disabled = false;
            }

            exportBtn.addEventListener('click', function () {
                page = 1;
                filename = null;
                exportBtn.disabled = true;
                exportBtn.innerText = 'Начата выгрузка...';
                exportChunk();
            });
        });
    </script>
@endsection



