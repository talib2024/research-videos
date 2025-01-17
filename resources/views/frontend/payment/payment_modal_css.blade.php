
<style>
fieldset {
    display: none;
}

fieldset.show {
    display: block;
}

select:focus, input:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #2196F3 !important;
    outline-width: 0 !important;
    font-weight: 400;
}

button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0;
}

.tabs {
    margin: 2px 5px 0px 5px;
    padding-bottom: 10px;
    cursor: pointer;
}

.tabs:hover, .tabs.active {
    border-bottom: 1px solid #2196F3;
}

a:hover {
    text-decoration: none;
    color: #888;
}

.box {
    margin-bottom: 10px;
    border-radius: 5px;
    padding: 10px;
}

.modal-backdrop { 
    background-color: #64B5F6;
}

.line {
    background-color: #CFD8DC;
    height: 1px;
    width: 100%;
}

@media screen and (max-width: 768px) {
    .tabs h6 {
        font-size: 12px;
    }
}
</style>