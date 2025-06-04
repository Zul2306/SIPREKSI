import pandas as pd
import numpy as np
from math import log2
import os

target_column = 'TARGET'
model_cache = {}  # Menyimpan tree dan atribut input per file CSV

def calculate_entropy(subset):
    if len(subset) == 0:
        return 0
    counts = subset[target_column].value_counts()
    probabilities = counts / len(subset)
    entropy = -sum(p * log2(p) for p in probabilities)
    return entropy

def count_classes(subset):
    return subset[target_column].value_counts().to_dict()

def get_majority_class(counts):
    return max(counts.items(), key=lambda x: x[1])[0]

def is_one_per_class(subset):
    counts = subset[target_column].value_counts()
    return len(subset) == 2 and set(counts.values) == {1} and len(counts) == 2


def build_tree_structure(data, used_attributes=None):
    if used_attributes is None:
        used_attributes = set()
    entropy = calculate_entropy(data)
    counts = count_classes(data)

    if entropy == 0 or len(data) < 2:
        return {
            "type": "leaf",
            "prediction": get_majority_class(counts),
            "class_counts": counts
        }

    gains = {}
    thresholds = {}
    for column in data.columns:
        if (column == target_column or
            column in used_attributes or
            not np.issubdtype(data[column].dtype, np.number)):
            continue
        threshold = data[column].mean()
        le_subset = data[data[column] <= threshold]
        gt_subset = data[data[column] > threshold]

        le_entropy = calculate_entropy(le_subset)
        gt_entropy = calculate_entropy(gt_subset)

        le_weight = len(le_subset) / len(data)
        gt_weight = len(gt_subset) / len(data)

        weighted_entropy = le_weight * le_entropy + gt_weight * gt_entropy
        gain = entropy - weighted_entropy

        gains[column] = gain
        thresholds[column] = threshold
       

    if not gains:
        return {
            "type": "leaf",
            "prediction": get_majority_class(counts),
            "class_counts": counts
        }

    best_attribute = max(gains, key=gains.get)
    threshold = thresholds[best_attribute]
    new_used_attributes = used_attributes | {best_attribute}

    le_data = data[data[best_attribute] <= threshold]
    gt_data = data[data[best_attribute] > threshold]

    #pengecekan jika node diteruskan akan menghasilkan leaf node kelas 1=1 dan 0=1
    if is_one_per_class(le_data) or is_one_per_class(gt_data):
        return {
            "type": "leaf",
            "prediction": get_majority_class(counts),
            "class_counts": counts
        }

    return {
        "type": "node",
        "attribute": best_attribute,
        "threshold": threshold,
        "class_counts": counts,
        "left": build_tree_structure(le_data, new_used_attributes),
        "right": build_tree_structure(gt_data, new_used_attributes)
    }

def predict(tree, input_data):
    if tree["type"] == "leaf":
        return tree["prediction"]
    attr = tree["attribute"]
    threshold = tree["threshold"]
    if input_data[attr] <= threshold:
        return predict(tree["left"], input_data)
    else:
        return predict(tree["right"], input_data)

def tree_input_attributes(tree, attributes=None):
    if attributes is None:
        attributes = set()
    if tree["type"] == "node":
        attributes.add(tree["attribute"])
        tree_input_attributes(tree["left"], attributes)
        tree_input_attributes(tree["right"], attributes)
    return sorted(attributes)

def load_model_from_csv(csv_filename):
    if csv_filename in model_cache:
        return model_cache[csv_filename]

    full_path = os.path.join("data", csv_filename)
    if not os.path.exists(full_path):
        raise FileNotFoundError(f"CSV file '{csv_filename}' tidak ditemukan.")

    df = pd.read_csv(full_path)
    tree = build_tree_structure(df)
    input_fields = tree_input_attributes(tree)
    model_cache[csv_filename] = {
        "tree": tree,
        "input_fields": input_fields
    }
    return model_cache[csv_filename]

def get_required_fields(csv_filename):
    model = load_model_from_csv(csv_filename)
    return model["input_fields"]

def predict_from_input_dict(csv_filename, input_dict):
    model = load_model_from_csv(csv_filename)
    return predict(model["tree"], input_dict)

def get_available_csv_files():
    return [f for f in os.listdir("data") if f.endswith(".csv")]

def get_feature_columns_from_csv(csv_filename):
    full_path = os.path.join("data", csv_filename)
    df = pd.read_csv(full_path)
    return [
        col for col in df.columns
        if col != target_column and np.issubdtype(df[col].dtype, np.number)
    ]
