            <div class="footer">
                &copy; <?php
                    $napravljeno = 2013;
                    $trenutno    = date('Y');
                    if ( $trenutno > $napravljeno ) echo $napravljeno . ' - ' . $trenutno;
                    else echo $napravljeno;
                ?> by Tanja B.
            </div>
        </div>
    </body>
</html>
