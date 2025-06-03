import pandas as pd
import math

# Hitung entropy dari target

def calculate_entropy(target_series):
    values = target_series.value_counts(normalize=True)
    return -sum(p * math.log2(p) for p in values if p > 0)

# Cari split terbaik berdasarkan gain tertinggi dari mean/median

def find_best_split(data, target):
    total_data = len(data)
    entropy_total = calculate_entropy(data[target])
    all_columns = data.columns.drop(target)
    numeric_columns = data[all_columns].select_dtypes(include=['number']).columns
    best = None

    for column in numeric_columns:
        for method in ['mean', 'median']:
            threshold = data[column].mean() if method == 'mean' else data[column].median()
            gt_split = data[data[column] > threshold]
            le_split = data[data[column] <= threshold]

            if len(gt_split) == 0 or len(le_split) == 0:
                continue

            entropy_gt = calculate_entropy(gt_split[target])
            entropy_le = calculate_entropy(le_split[target])
            gain = entropy_total - (len(gt_split) / total_data) * entropy_gt - (len(le_split) / total_data) * entropy_le

            if best is None or gain > best['gain']:
                best = {
                    'column': column,
                    'method': method,
                    'threshold': threshold,
                    'gain': gain,
                    'gt_split': gt_split,
                    'le_split': le_split
                }
    return best

# Bangun decision tree secara rekursif

def build_tree(data, target, depth=0, max_depth=12):
    counts = data[target].value_counts().to_dict()
    samples = len(data)
    is_pure_leaf = len(counts) == 1
    is_single_sample = samples == 1

    if samples == 0 or is_pure_leaf or is_single_sample or depth >= max_depth:
        if samples == 0:
            return {'type': 'leaf', 'class': 'Unknown'}
        chosen = max(counts, key=counts.get)
        return {'type': 'leaf', 'class': chosen}

    split = find_best_split(data, target)
    if split is None or split['gain'] <= 0:
        chosen = max(counts, key=counts.get)
        return {'type': 'leaf', 'class': chosen}

    return {
        'type': 'node',
        'column': split['column'],
        'method': split['method'],
        'threshold': split['threshold'],
        'left': build_tree(split['le_split'], target, depth + 1, max_depth),
        'right': build_tree(split['gt_split'], target, depth + 1, max_depth)
    }

# Prediksi menggunakan pohon keputusan

def predict_tree(tree, input_data):
    if tree['type'] == 'leaf':
        return tree['class']

    value = input_data[tree['column']]
    if value <= tree['threshold']:
        return predict_tree(tree['left'], input_data)
    else:
        return predict_tree(tree['right'], input_data)
