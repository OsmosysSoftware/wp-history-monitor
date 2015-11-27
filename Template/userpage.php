<div class="main-container">
    <div class="datepickers-container">
        <form class="form-inline" role="form">
            <div class="form-group">
                <label for="txtFromDate">From</label>
                <div class="input-group" id='datetimepickerone'>
                    <input type="text" class="form-control" id="txtFromDate" placeholder="From date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="txtToDate">To</label>
                <div class="input-group" id='datetimepickertwo'>
                    <input type="text" class="form-control" id="txtToDate" placeholder="To date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="buttons-container">
        <button id="getPostButtonId" class="button">Show posts published</button>
        <button id="getPageButtonId" class="button">Show pages published</button>
        <button id="getUserButtonId" class="button">Show users registered</button>
    </div>
</div>
<div id="dateError"></div>
<div id="ajaxFailMsg"></div>
<div id="user-posts"></div>
<div id="user-pages"></div>
<div id="user-registered"></div>

