    <!-- JQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Animate On Scroll Library --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script> --}}


    {{-- bootstrap --}}


    <script src="{{ asset('front_end_style/js/bootstrap.min.js') }}"></script>
    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-q2kG4FR9m3pMDnIeK6QOYF1jQQsuZ9iMsFL5vlwPQvvx43pCiFxOFbR2Q9P5BGFh" crossorigin="anonymous">
    </script>


    {{-- Sweet Alert --}}
    <script src="{{ asset('front_end_style/js/sweetalert2.min.js') }}"></script>
    {{-- =========================================================== --}}
    {{-- ================== Sweet Alert Section ==================== --}}
    {{-- =========================================================== --}}
    @if (session()->has('success'))
        <script>
            Swal.fire(
                "Thanks",
                "{!! Session::get('success') !!}",
                "success",
            );
        </script>
    @endif
    @if (session()->has('danger'))
        <script>
            Swal.fire(
                "Sorry",
                "{!! Session::get('danger') !!}",
                "error",
            );
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const taskCountBadge = document.getElementById("task-reminder-count");

            // Fetch the task reminder count
            // fetch("/tasks/reminder-count")
            fetch("#")
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        taskCountBadge.textContent = data.count;
                        taskCountBadge.style.display = "inline-block";
                    } else {
                        taskCountBadge.style.display = "none";
                    }
                })
                .catch(error => {
                    console.error("Error fetching task reminder count:", error);
                    taskCountBadge.style.display = "none";
                });
        });
    </script>


    </body>

    </html>
