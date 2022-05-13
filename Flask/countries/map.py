from flask import Blueprint
from flask import request
import requests
from flask import jsonify
from funcy import pluck

countries_map = Blueprint("countries_map", __name__)

@countries_map.route('/countries/map')
def get_countries_map():

    dspace_base_url = request.args.get("dspace_base_url")

    params = {
        "page": request.args.get("page", default = 1, type = int),
        "rows": request.args.get("rows", type = int),
        "start_date": request.args.get("start_date", default = None, type = str),
        "end_date": request.args.get("end_date", default = None, type = str),
    }

    data = {
        "countries" : [],
    }
    alldata =  []
    result = {}

    data["countries"] = SOLRConstructor() \
        .set_collection("search") \
        .set_q("dc.publisher.place:*") \
        .set_start("1") \
        .set_fl("dc.publisher.place") \
        .set_facet_field("dc.publisher.place") \
        .request(dspace_base_url) \
        ["response"] \
        ["result"] \
        ["doc"]



    for key in data["countries"]:
        extraction =key["arr"]["str"]
        alldata.append(extraction)
       

    result = dict((i, alldata.count(i)) for i in alldata)
 
    return jsonify(result)