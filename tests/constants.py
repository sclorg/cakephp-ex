TAGS = {
    "rhel8": "-ubi8",
    "rhel9": "-ubi9",
    "rhel10": "-ubi10",
}


def is_test_allowed(os, version):
    if os == "rhel8" and version in ["7.4", "8.2"]:
        return True
    if os == "rhel9" and version in ["8.0", "8.2", "8.3"]:
        return True
    if os == "rhel10" and version in ["8.3", "8.4"]:
        return True
    return False
