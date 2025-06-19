with open("C:\\xampp\\htdocs\\demoiot\\data_falling.txt", 'r') as file:
    lines = file.readlines()

modified_lines = [line.strip() + ' falling\n' for line in lines]

with open("C:\\xampp\\htdocs\\demoiot\\data_falling.txt", 'w') as file:
    file.writelines(modified_lines)
