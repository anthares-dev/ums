<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark  bg-dark d-flex justify-content-center">




        <form class="form-inline mt-2 mt-md-0" method="get" action="<?=$pageUrl?>" id="searchForm">
            <input type="hidden" name="page" value="<?=$page?>" id="page">
            <div class="form-group">
                <div class="form-group mr-2">
                    <label for="recordsPerPage">Order by</label>
                    <select name="orderBy" class="form-control" id="orderBy"
                        onchange="document.forms.searchForm.submit()">
                        <option value="">SELECT</option>
                        <?php
foreach ($orderByColumns as $val) {
    ?>
                        <option <?=$orderBy == $val ? 'selected' : ''?> value="<?=$val?>"><?=$val?></option>
                        <?php
}
?>

                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="recordsPerPage">Order</label>
                    <select name="orderDir" class="form-control" id="orderDir"
                        onchange="document.forms.searchForm.submit()">
                        <option <?=$orderDir == 'ASC' ? 'selected' : ''?> value="ASC">ASC</option>
                        <option <?=$orderDir == 'DESC' ? 'selected' : ''?> value="DESC">DESC</option>

                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="recordsPerPage">RECORDS PER PAGE</label> <select name="recordsPerPage"
                        class="form-control" id="recordsPerPage"
                        onchange="document.forms.searchForm.page.value=1; document.forms.searchForm.submit()">
                        <option value="">SELECT</option>
                        <?php
foreach ($recordsPerPageOptions as $val) {
    ?>
                        <option <?=$recordsPerPage == $val ? 'selected' : ''?> value="<?=$val?>"><?=$val?></option>
                        <?php
}
?>

                    </select>
                </div>
            </div>
            <input class="form-control mr-sm-2" type="text" name="search" id="search" value="<?=$search?>"
                placeholder="Search" aria-label="Search">
            <button onclick="document.forms.searchForm.page.value=1" class="btn btn-outline-success my-2 my-sm-0 mr-2"
                type="submit">
                Search
            </button>
            <button onclick="location.href='<?=$pageUrl?>'" class="btn btn-outline-warning my-2 my-sm-0" type="button">

                Reset
            </button>
        </form>

    </nav>
</header>