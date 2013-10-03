<style type="text/css">
.messages-nav {
    margin-top: 22px;
}
    
.tabs, .pills {
  margin: 0 0 18px;
  padding: 0;
  list-style: none;
  zoom: 1;
}
.tabs:before,
.pills:before,
.tabs:after,
.pills:after {
  display: table;
  content: "";
  zoom: 1;
}
.tabs:after, .pills:after {
  clear: both;
}
.tabs > li, .pills > li {
  float: left;
}
.tabs > li > a, .pills > li > a {
  display: block;
}

.pills a {
  margin: 5px 3px 5px 0;
  padding: 0 15px;
  line-height: 30px;
  text-shadow: 0 1px 1px #ffffff;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
}
.pills a:hover {
  color: #ffffff;
  text-decoration: none;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25);
  background-color: #00438a;
}
.pills .active a {
  color: #ffffff;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25);
  background-color: #0069d6;
}
table {
  width: 100%;
  margin-bottom: 18px;
  padding: 0;
  font-size: 15px;
  border-collapse: collapse;
}

.bordered-table {
  border: 1px solid #ddd;
  border-collapse: separate;
  *border-collapse: collapse;
  /* IE7, collapse table to remove spacing */

  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
}
.bordered-table th + th, .bordered-table td + td, .bordered-table th + td {
  border-left: 1px solid #ddd;
}
.bordered-table thead tr:first-child th:first-child, .bordered-table tbody tr:first-child td:first-child {
  -webkit-border-radius: 4px 0 0 0;
  -moz-border-radius: 4px 0 0 0;
  border-radius: 4px 0 0 0;
}
.bordered-table thead tr:first-child th:last-child, .bordered-table tbody tr:first-child td:last-child {
  -webkit-border-radius: 0 4px 0 0;
  -moz-border-radius: 0 4px 0 0;
  border-radius: 0 4px 0 0;
}
.bordered-table tbody tr:last-child td:first-child {
  -webkit-border-radius: 0 0 0 4px;
  -moz-border-radius: 0 0 0 4px;
  border-radius: 0 0 0 4px;
}
.bordered-table tbody tr:last-child td:last-child {
  -webkit-border-radius: 0 0 4px 0;
  -moz-border-radius: 0 0 4px 0;
  border-radius: 0 0 4px 0;
}
.zebra-striped tbody tr:nth-child(odd) td, .zebra-striped tbody tr:nth-child(odd) th {
  background-color: #f9f9f9;
}
.zebra-striped tbody tr:hover td, .zebra-striped tbody tr:hover th {
  background-color: #f5f5f5;
}
th.from-to {
    width: 200px;
}
tr.unread td {
    font-weight: bold;
}
.btn.danger,
.alert-message.danger,
.btn.error,
.alert-message.error {
  background-color: #c43c35;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#ee5f5b), to(#c43c35));
  background-image: -moz-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -ms-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ee5f5b), color-stop(100%, #c43c35));
  background-image: -webkit-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -o-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: linear-gradient(top, #ee5f5b, #c43c35);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ee5f5b', endColorstr='#c43c35', GradientType=0);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #c43c35 #c43c35 #882a25;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
}
.btn.danger,
.alert-message.danger,
.btn.danger:hover,
.alert-message.danger:hover,
.btn.error,
.alert-message.error,
.btn.error:hover,
.alert-message.error:hover,
.btn.success,
.alert-message.success,
.btn.success:hover,
.alert-message.success:hover,
.btn.info,
.alert-message.info,
.btn.info:hover,
.alert-message.info:hover {
  color: #ffffff;
}
</style>