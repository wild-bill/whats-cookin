from bs4 import BeautifulSoup
import urllib.request
import json
import csv

# 2.10.17
"""This program will scrape recipe data from Foodnetwork.com. It would probably work on any other recipe sites that use JSON to store the data"""

# this should be a list of links so that the program can just loop through it and get a bunch of recipes





recipes = ["http://www.foodnetwork.com/recipes/food-network-kitchen/eggplant-and-tofu-curry-recipe","http://www.foodnetwork.com/recipes/rachael-ray/spinach-and-artichoke-baked-whole-grain-pasta-recipe", "http://www.foodnetwork.com/recipes/easy-mushroom-vegetable-paella-recipe", "http://www.foodnetwork.com/recipes/rachael-ray/ravioli-vegetable-lasagna-recipe","http://www.foodnetwork.com/recipes/rachael-ray/instant-pesto-torta-with-bread-and-vegetables-recipe"]




with open('recipes.csv', 'w', newline='\n') as f:
	writer = csv.writer(f)
	idCounter = 1
#create the soup
	for recipe in recipes:
		r = urllib.request.urlopen(recipe).read()
		soup = BeautifulSoup(r, "html.parser")

		#find the JSON section in the HTML
		json_tag = soup.find("script", type="application/ld+json") #that last part could be a variable I guess
		jString = json_tag.string
		d = json.loads(jString) #change 'd' to something more descriptive

		#print(d['name']+"\n")
		#print(d['cookTime']+"\n") #this spits out a time code. maybe ignore it anyway?

		#loop through the ingredients and print them to the screen. obviously we'll want them somewhere else
		i=0
		while i<len(d["recipeIngredient"]):
			#print(d["recipeIngredient"][i])
			i+=1 

		print("\n")

		i=0
		while i<len(d["recipeInstructions"]):
			#print(d["recipeInstructions"][i])
			i+=1
		# can probably stand to clean this portion up a bit...also printing the non-looped guys out as individual cells
		writer.writerow([idCounter,d['name'],"A delicious recipe!",d['recipeCategory'],"",d['recipeYield'], "",""])
		writer.writerow([d['recipeYield']])
		try:
			writer.writerow([d['cookTime'],d['totalTime']])
			#writer.writerow([d['totalTime']])
		except KeyError:
			print("No cook time given")
			
		for item in d["recipeInstructions"]:
			writer.writerow([item])
			#writer.writerows(d["recipeInstructions"])
		for item in d["recipeIngredient"]:
			writer.writerow([item])
		writer.writerow("\n")
		idCounter += 1
	


#print(d["recipeIngredient"]) #this will print out the ingredients as A LIST. Can do by reference which means can iterate through
#print(len(d["recipeIngredient"]))

#so can iterate through the list

#name AND headline (think they're the same. this is recipe name
#cookTime (one value)
#totalTime (one value)
#recipeCategory (multiple, don't know that i need this)
#recipeIngredient (this is an important one, multiple)
#nutrition (this looks like a hash...might be nice but "nice to have")
#recipeInstructions (same as ingredient)
#recipeYield (one value)

"""The ideal solution here would be to generate a CSV file for each table"""
#Recipe Step Ingredients: Recipe_ID, Step_No, Ingredient_ID, Step_Amount, Unit_ID
