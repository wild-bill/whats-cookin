#we want to create the soup only once for each link.
#we want to open and write to the file only once per table
from bs4 import BeautifulSoup
import urllib.request
import json
import csv

def createSoup(recipe):
	r = urllib.request.urlopen(recipe).read()
	soup = BeautifulSoup(r, 'html.parser')
	
	#find the JSON section in the HTML
	json_tag = soup.find("script", type="application/ld+json") #that last part could be a variable I guess, based on recipe site
	jString = json_tag.string
	jData = json.loads(jString)
	return jData

def createTables(data):
	for table in tables:
		with open(table+'.csv', 'w', newline='\n') as f:
			writer = csv.writer(f)
			if table == 'recipe':
				build_recipe_table(idCounter, writer)
			elif table == 'step':
				build_step_table(idCounter, writer)
			elif table == 'step_ingredient':
				build_step_ingredient_table(idCounter, writer)
			elif table == 'unit':
				build_unit_table(idCounter, writer)
			elif table == 'ingredient':
				build_ingredient_table(idCounter, writer)
			else:
				print("Something went wrong")

def build_ingredient_table(idCounter,writer):
	writer.writerow(['Ingredient_ID', 'Ingredient_Name', 'Ingredient_Best_Store'])
	#we want all ingredients here all together
	allIngredients = []
	for recipe in recipeData:
		i = 0
		print("breakpoint 1")
		while i<len(recipe['recipeIngredient']):
			if(recipe['recipeIngredient'][i]) not in allIngredients:
				allIngredients.append(recipe['recipeIngredient'][i])
			i += 1
	for ingredient in allIngredients:
		writer.writerow([idCounter+1, ingredient, ""])
		idCounter += 1
	
def build_recipe_table(idCounter,writer):
	writer.writerow(['Recipe_ID', 'Recipe_Name', 'Recipe_Description', 'Recipe_Style', 'Recipe_Skill_Level', 'Recipe_Serves', 'Recipe_Course', 'Recipe_IsHealthy'])
	for recipe in recipeData:
		idCounter += 1
		writer.writerow([idCounter,recipe['name'],"A delicious recipe!",recipe['recipeCategory'],"",recipe['recipeYield'], "",""])
	
def build_step_ingredient_table(idCounter,writer):
	writer.writerow(['Recipe_ID', 'Step_No', 'Ingredient_ID', 'Step_Amount', 'Unit_ID'])
	for recipe in recipeData:
		jData = recipe
		idCounter += 1
		
	
def build_step_table(idCounter,writer):
	writer.writerow(['Recipe_ID', 'Step_No', 'Step_Instructions', 'Step_Time', 'Unit_ID'])
	for recipe in recipeData:
		idCounter += 1
		stepNo = 0
		while stepNo < len(recipe['recipeInstructions']):
			writer.writerow([idCounter,stepNo+1,recipe['recipeInstructions'][stepNo],"",1])
			stepNo += 1
	
def build_unit_table(x,y):
	pass

idCounter=0
tables = ('recipe','step','step_ingredient','ingredient','unit')		
recipes = ["http://www.foodnetwork.com/recipes/food-network-kitchen/eggplant-and-tofu-curry-recipe","http://www.foodnetwork.com/recipes/rachael-ray/spinach-and-artichoke-baked-whole-grain-pasta-recipe", "http://www.foodnetwork.com/recipes/easy-mushroom-vegetable-paella-recipe", "http://www.foodnetwork.com/recipes/rachael-ray/ravioli-vegetable-lasagna-recipe","http://www.foodnetwork.com/recipes/rachael-ray/instant-pesto-torta-with-bread-and-vegetables-recipe"]
units = ('cup', 'cups', 'tablespoon', 'tablespoons', 'can', 'cans', 'box', 'boxes', 'ounce', 'ounces', 'clove', 'cloves', 'piece', 'pieces', 'leaf', 'leaves', 'teaspoon', 'teaspoons')
recipeData = []
for recipe in recipes:
	recipeData.append(createSoup(recipe))
	
createTables(recipeData)